<?php


class qa_ServiceProviders_Utils extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container->singleton('qa_Interfaces_MessageFormatter', 'qa_Utils_MessageFormatter');
	}

	/**
	 * Binds and sets up implementations at boot time.
	 */
	public function boot() {
		// no-op
	}
}