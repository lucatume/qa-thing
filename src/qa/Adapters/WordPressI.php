<?php

interface qa_Adapters_WordPressI {
	/**
	 * Proxy for the `get_plugins` function
	 *
	 * @see get_plugins()
	 *
	 * @return array
	 */
	public function get_plugins($plugin_folder = '');

	/**
	 * Gets the WP_PLUGIN_DIR constant.
	 *
	 * @param null|string $path An optional path to append
	 *
	 * @return string
	 */
	public function plugin_dir($path = null);

	/**
	 * Proxy for the `get_option` function.
	 *
	 * @see get_option()
	 *
	 * @param string $option
	 * @param mixed $default
	 * @return mixed
	 */
	public function get_option($option, $default = false);

	/**
	 * Proxy for the `update_option` function.
	 *
	 * @see update_option()
	 *
	 * @param string $option
	 * @param mixed $value
	 * @param string|bool $autoload
	 */
	public function update_option($option, $value, $autoload = null);

	/**
	 * Proxy for the `__` function.
	 *
	 * @see __()
	 *
	 * @param string $text
	 * @param string $domain
	 * @return string
	 */
	public function __( $text, $domain = 'default' );
}