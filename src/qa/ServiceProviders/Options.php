<?php

class qa_ServiceProviders_Options extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container['options.page-slug'] = 'qa-options';
		$this->container['options.option'] = 'qa-thing';

		$this->container->singleton('qa_Options_RepositoryI', 'qa_Options_Repository');
		$optionsPage = $this->container->instance('qa_Options_Page', array('options.page-slug', 'qa_Configurations_ScannerI'));
		$this->container->singleton('qa_Options_PageI', $optionsPage);

		add_action('admin_menu', array($this, 'addOptionsPage'));
	}

	/**
	 * Adds the options page to the menu.
	 */
	public function addOptionsPage() {
		add_menu_page(
			__('QA Thing', 'qa'),
			__('QA Thing', 'qa'),
			'manage_options',
			$this->container['options.page-slug'],
			$this->container->callback('qa_Options_PageI', 'render')
		);
	}
}