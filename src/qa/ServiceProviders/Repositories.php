<?php


class qa_ServiceProviders_Repositories extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container->singleton( 'qa_Interfaces_IssueConfigsRepository', 'qa_Configurations_Repository' );
		$this->container->singleton('qa_Interfaces_IssueRepository','qa_Issues_Repository');
	}

	/**
	 * Binds and sets up implementations at boot time.
	 */
	public function boot() {
		// no-op
	}
}