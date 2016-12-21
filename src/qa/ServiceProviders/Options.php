<?php


class qa_ServiceProviders_Options extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container->singleton( 'qa_Interfaces_OptionsPage', 'qa_Options_Page' );
	}

	/**
	 * Binds and sets up implementations at boot time.
	 */
	public function boot() {
		$options_page = $this->container->make( 'qa_Interfaces_OptionsPage' );
		add_action( 'admin_menu', [ $options_page, 'register' ] );
		add_action( 'admin_init', [ $options_page, 'register_settings' ] );
	}
}