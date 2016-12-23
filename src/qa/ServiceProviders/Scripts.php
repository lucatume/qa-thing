<?php


class qa_ServiceProviders_Scripts extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container['assets']       = $assets = plugins_url( '/assets', $this->container['root-file'] );
		$this->container['node-modules'] = $nodeModules = plugins_url( '/node_modules', $this->container['root-file'] );

		add_action( 'wp_enqueue_scripts', array( $this, 'registerScripts' ) );
	}

	/**
	 * Binds and sets up implementations at boot time.
	 */
	public function boot() {
		// no-op
	}

	public function registerScripts() {
		$assets = $this->container['assets'];

		$postfix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style( 'qa-style', $assets . '/css/qa-style' . $postfix . '.css' );
		wp_register_script( 'qa-script', $assets . '/js/qa-script' . $postfix . '.js', array( 'jquery' ) );
	}
}