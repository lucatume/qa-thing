<?php


class qa_Issues_ConfigurationApplication implements qa_Interfaces_IssueConfigurationApplication {

	/**
	 * @var string
	 */
	protected $option;
	/**
	 * @var qa_Interfaces_MessageFormatter
	 */
	protected $formatter;

	/**
	 * @var string
	 */
	protected $outputOption;

	/**
	 * @var int
	 */
	protected $transientExpiration = 600;

	/**
	 * qa_Issues_ConfigurationApplication constructor.
	 *
	 * @param qa_Interfaces_MessageFormatter $formatter
	 */
	public function __construct( qa_Interfaces_MessageFormatter $formatter ) {
		$this->formatter = $formatter;
	}

	/**
	 * Applies the requested configuration.
	 *
	 * @param qa_Interfaces_IssueConfig $config
	 *
	 * @return string The script execution output
	 */
	public function apply( qa_Interfaces_IssueConfig $config ) {
		if ( empty( $config->getTarget() ) || empty( $config->getPlugin() ) ) {
			return true;
		}

		$this->option       = 'qa-status-' . $config->getId();
		$this->outputOption = 'qa-output-' . $config->getId();

		$status = $this->getStatus();

		if ( $status === 'done' ) {
			$response = new WP_REST_Response( $this->getOutput() );
			$response->header( 'X-IC-CancelPolling', 'true' );

			delete_transient( $this->option );
			delete_transient( $this->outputOption );

			return $response;
		}

		if ( $status !== 'applying' ) {
			try {
				$plugin = $config->getPlugin();
				$script = dirname( WP_PLUGIN_DIR . '/' . $plugin['file'] ) . '/' . $config->getTarget();

				if ( ! file_exists( $script ) ) {
					$message  = $this->formatter->formatError( sprintf( __( 'Target script [%1$s] does not exist.', 'qa' ),
						$script ) );
					$response = new WP_REST_Response( $message );
					$response->header( 'X-IC-CancelPolling', 'true' );

					return $response;
				}

				$this->setStatus( 'applying' );

				$pid = pcntl_fork();

				if ( $pid === - 1 ) {
					throw new RuntimeException( 'Could not fork process' );
				}

				/** @var \wpdb $wpdb */
				global $wpdb;
				/** @noinspection PhpParamsInspection */
				mysqli_close( $wpdb->dbh );

				if ( $pid === 0 ) {
					$wpdb->__construct( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );

					/** @noinspection PhpUnusedLocalVariableInspection */
					$messages = new qa_Utils_Messages( $this->outputOption, $this->formatter );
					include $script;

					$this->setStatus( 'done' );

					return '';
				} else {
					$wpdb->__construct( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
				}
			} catch ( Exception $e ) {
				$lines = array();
				/** @noinspection PhpUndefinedVariableInspection */
				$lines[] = sprintf( __( 'The script [%1$s] generated errors: ', 'qa' ), $script );
				$lines   = array_merge( $lines, explode( PHP_EOL, $e->getMessage() ) );
				$lines[] = 'File: ' . $e->getFile();
				$lines[] = 'Line: ' . $e->getLine();

				$this->setOutput( $this->formatter->formatError( $lines ) );

				$this->setStatus( 'done' );
			}
		}

		$response = new WP_REST_Response( $this->getOutput() );

		return $response;
	}

	protected function getStatus() {
		return get_transient( $this->option );
	}

	/**
	 * @return string
	 */
	protected function getOutput() {
		return implode( PHP_EOL, (array) get_transient( $this->outputOption ) );
	}

	protected function setStatus( $status ) {
		set_transient( $this->option, $status, $this->transientExpiration );
	}

	protected function setOutput( $output ) {
		$current = $this->getOutput();
		set_transient( $this->outputOption, $current . $output );
	}
}