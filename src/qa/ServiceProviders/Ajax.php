<?php

class qa_ServiceProviders_Ajax extends tad_DI52_ServiceProvider {
	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$applyConfigurationHandler = $this->container->instance('qa_Ajax_ConfigurationApplyHandler');
		$getLastStatusHandler = $this->container->instance('qa_Ajax_GetLastStatusHandler');

		add_action('wp_ajax_qa_apply_configuration', $this->container->callback($applyConfigurationHandler, 'handle'));
		add_action('wp_ajax_qa_get_last_status', $this->container->callback($getLastStatusHandler, 'handle'));
	}
}