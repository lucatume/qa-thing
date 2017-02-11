<?php

class qa_ServiceProviders_Ajax extends tad_DI52_ServiceProvider {
	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container->bind('qa_Ajax_AjaxHandlerI', 'qa_Ajax_AjaxHandler');
		$handler = $this->container->instance('qa_Ajax_AjaxHandlerI');

		add_action('wp_ajax_qa_apply_configuration', $this->container->callback($handler, 'handle'));
	}
}