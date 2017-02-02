<?php

class qa_ServiceProviders_Adapters extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container->singleton('qa_Adapters_WordPressI', 'qa_Adapters_WordPress');
	}
}