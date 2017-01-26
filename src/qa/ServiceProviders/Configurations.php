<?php


class qa_ServiceProviders_Configurations extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container->singleton('qa_Configurations_ScannerI', 'qa_Configurations_Scanner');
	}
}