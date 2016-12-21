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

		if ( $this->getStatus() !== 'applying' && $this->getStatus() !== 'done' ) {
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
				mysqli_close( $wpdb->dbh );

				if ( $pid === 0 ) {
					$wpdb->__construct( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );

					$messages = new qa_Utils_Messages( $this->outputOption, $this->formatter );
					include $script;

					$this->setStatus( 'done' );

					return '';
				} else {
					$wpdb->__construct( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
				}
			} catch ( Exception $e ) {
				$message = sprintf( __( 'The script [%1$s] generated errors: ', 'qa' ), $script ) . '<pre><code>' . $e->getMessage()
				           . '</code></pre>';
				$message = $this->formatter->formatError( $message );

				$this->setStatus( 'done' );

				$response = new WP_REST_Response( $message );
				$response->header( 'X-IC-CancelPolling', 'true' );

				return $response;
			}

			$response = new WP_REST_Response( $this->getOutput() );
			$response->header( 'X-IC-ResumePolling', 'true' );

			return $response;
		} elseif ( $this->getStatus() === 'done' ) {
			$response = new WP_REST_Response( $this->getOutput() );
			$response->header( 'X-IC-CancelPolling', 'true' );

			delete_transient( $this->option );
			delete_transient( $this->outputOption );

			return $response;
		}

		return new WP_REST_Response( $this->getOutput() );
	}

	protected function getStatus() {
		return get_transient( $this->option );
	}

	protected function setStatus( $status ) {
		set_transient( $this->option, $status, $this->transientExpiration );
	}

	/**
	 * @return string
	 */
	protected function getOutput() {
		return implode( PHP_EOL, (array) get_transient( $this->outputOption ) );
	}
}