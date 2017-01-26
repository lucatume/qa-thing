<?php

class qa_Configurations_Scanner implements qa_Configurations_ScannerI {

	/**
	 * Returns an array of the available configurations.
	 *
	 * @return qa_Configurations_ConfigurationI[]
	 */
	public function configurations() {
		$configurationProviders = $this->scanPlugins();

		if ( empty( $configurationProviders ) ) {
			return array();
		}

		return call_user_func_array( 'array_merge', array_map( array( $this, 'buildConfigurations' ), $configurationProviders ) );
	}

	protected function scanPlugins() {
		if ( ! function_exists( 'get_plugins' ) ) {
			include_once ABSPATH . '/' . WPINC . '/plugin.php';
		}

		$plugins = get_plugins();

		if ( empty( $plugins ) ) {
			return array();
		}

		array_walk( $plugins, array( $this, 'addPaths' ) );

		$plugins = array_filter( $plugins, array( $this, 'hasConfig' ) );

		return $plugins;
	}

	protected function addPaths( array &$data, $path ) {
		$data['path'] = WP_PLUGIN_DIR . '/' . $path;
		$data['root'] = dirname( WP_PLUGIN_DIR . '/' . $path );
	}

	protected function hasConfig( array $data ) {
		return is_readable( $data['root'] . '/qa/qa-config.json' );
	}

	protected function buildConfigurations( array $data ) {
		$info = file_get_contents( $data['root'] . '/qa/qa-config.json' );
		$info = (array) json_decode( $info );
		$configurations = array();
		foreach ( $info['configurations'] as $id => $configuration ) {
			$configurations[] = new qa_Configurations_Configuration( $id, (array) $configuration, $data );
		}

		return $configurations;
	}
}