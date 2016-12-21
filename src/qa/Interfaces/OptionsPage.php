<?php


interface qa_Interfaces_OptionsPage {

	/**
	 * Register the page.
	 *
	 * @return false|string The resulting page's hook_suffix, or false if the user does not have the capability required.
	 */
	public function register();

	/**
	 * Registers the page settings
	 */
	public function register_settings();
}