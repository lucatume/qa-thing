<?php


class qa_Issues_Repository implements qa_Interfaces_IssueRepository {

	/**
	 * @var qa_Interfaces_IssueConfigsRepository
	 */
	protected $issueConfigs;

	public function __construct( qa_Interfaces_IssueConfigsRepository $issueConfigs ) {
		$this->issueConfigs = $issueConfigs;
	}

	/**
	 * Returns all the issues.
	 *
	 * @return qa_Interfaces_IssueInterface[]
	 */
	public function getAll() {
		$issueConfigs = $this->issueConfigs->getAll();

		return array_map( array( $this, 'createIssue' ), $issueConfigs );
	}

	protected function createIssue( qa_Interfaces_IssueConfig $config ) {
		$title = $config->getPluginName() . ' - ' . $config->getTitle();
		$issue = new qa_Issues_Issue( $config->getId(), $title, $config->getTarget(), $config->getPlugin(),
			$config->getDescription() );

		return $issue;
	}

	/**
	 * @param $configSlug
	 *
	 * @return stdClass The plugin configuration object.
	 *
	 * @throws InvalidArgumentException If the configuration slug is not a string or is
	 *                                  not in the right format.
	 * @throws RuntimeException If the plugin was not found, the configuration file was
	 *                          not found, could not be read and decoded or the issue was
	 *                          not found in the configuration file.
	 */
	public function readConfigFor( $configSlug ) {
		if ( ! is_string( $configSlug ) ) {
			throw new InvalidArgumentException( 'Config slug must be a string' );
		}

		$frags = explode( ':', $configSlug );

		if ( count( $frags ) !== 2 ) {
			throw new InvalidArgumentException( "Configuration slug should be in the <plugin>:<issue> format (is '{$configSlug}')" );
		}

		$pluginSlug = $frags[0];
		$issueSlug  = $frags[1];

		if ( ! function_exists( 'get_plugins' ) ) {
			include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}

		$plugins = get_plugins();

		foreach ( $plugins as $file => $info ) {
			if ( $pluginSlug !== sanitize_title( $info['Name'] ) ) {
				continue;
			}

			$qaConfigFilePath = dirname( WP_PLUGIN_DIR . '/' . $file ) . '/qa/qa-config.json';

			if ( ! file_exists( $qaConfigFilePath ) ) {
				throw  new RuntimeException( "QA configuration file does not exist at '{$qaConfigFilePath}'" );
			}

			$contents = file_get_contents( $qaConfigFilePath );

			if ( empty( $contents ) ) {
				throw new RuntimeException( "QA configuration file '{$qaConfigFilePath}' is empty" );
			}

			$decoded = json_decode( $contents );

			if ( null === $decoded ) {
				throw new RuntimeException( "QA configuration file '{$qaConfigFilePath}' could not be decoded" );
			}

			if ( empty( $decoded->issues->{$issueSlug} ) ) {
				throw new RuntimeException( "QA configuration file '{$qaConfigFilePath}' does not contain any configuration for the issue '{$issueSlug}'" );
			}

			$info ['file']                         = $file;
			$decoded->issues->{$issueSlug}->id     = $issueSlug;
			$decoded->issues->{$issueSlug}->plugin = $info;

			return $decoded->issues->{$issueSlug};
		}

		throw new RuntimeException( "Plugin '$pluginSlug' was not found" );
	}
}