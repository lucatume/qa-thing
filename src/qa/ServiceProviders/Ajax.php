<?php

class qa_ServiceProviders_Ajax extends tad_DI52_ServiceProvider {
	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container->bind('qa_Ajax_HandlerI', 'qa_Ajax_Handler');
		$handler = $this->container->instance('qa_Ajax_HandlerI');

		add_action('wp_ajax_qa_apply_configuration', $this->container->callback($handler, 'handle'));
	}
}