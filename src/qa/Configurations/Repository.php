<?php


class qa_Configurations_Repository implements qa_Interfaces_IssueConfigsRepository {

	/**
	 * Gets all the issue configurations available.
	 *
	 * @return array
	 */
	public function getAll() {
		$plugins = get_plugins();

		$configs = array_filter( array_map( array( $this, 'readIssueConfigsFromPlugin' ), array_keys( $plugins ) ) );
		$configs = call_user_func_array( 'array_merge', $configs );

		return array_map( array( $this, 'createIssueConfig' ), $configs );
	}

	protected function readIssueConfigsFromPlugin( $plugin ) {
		$folder = dirname( WP_PLUGIN_DIR . '/' . $plugin );

		$qaFolder = $folder . '/' . 'qa';
		$qaConfigFile = $qaFolder . '/qa-config.json';

		if ( ! file_exists( $qaConfigFile ) ) {
			return false;
		}

		$contents = file_get_contents( $qaConfigFile );

		if ( false === $contents ) {
			return false;
		}

		$config = json_decode( $contents );

		if ( empty( $config->issues ) ) {
			return false;
		}

		$issues = array_filter( (array) $config->issues, array( $this, 'validateIssueConfig' ) );

		$pluginInfo = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
		$pluginInfo['file'] = $plugin;

		foreach ( $issues as $id => $issue ) {
			$issue->id = $id;
			$issue->plugin = $pluginInfo;
		}

		return $issues;
	}

	protected function validateIssueConfig( stdClass $issueConfig ) {
		return ! empty( $issueConfig->title )
			   && ! empty( $issueConfig->target );
	}

	protected function createIssueConfig( $issueConfig ) {
		return new qa_Issues_Config( (object) $issueConfig );
	}
}