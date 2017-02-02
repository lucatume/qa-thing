<?php

class qa_Adapters_WordPress implements qa_Adapters_WordPressI {
	/**
	 * Proxy for the `get_plugins` function
	 *
	 * @see get_plugins()
	 *
	 * @return array
	 */
	public function get_plugins($plugin_folder = '') {
		if (!function_exists('get_plugins')) {
			include_once ABSPATH . '/' . WPINC . '/plugin.php';
		}

		return get_plugins($plugin_folder);
	}

	/**
	 * Gets the WP_PLUGIN_DIR constant.
	 *
	 * @param null|string $path An optional path to append
	 *
	 * @return string
	 */
	public function plugin_dir($path = null) {
		if (null !== $path) {
			return trailingslashit(WP_PLUGIN_DIR) . ltrim($path, DIRECTORY_SEPARATOR);
		}
		return trailingslashit(WP_PLUGIN_DIR);
	}

	/**
	 * Proxy for the `get_option` funciton.
	 *
	 * @see get_option()
	 *
	 * @param string $option
	 * @param mixed $default
	 * @return mixed
	 */
	public function get_option($option, $default = false) {
		return get_option($option, $default);
	}

	/**
	 * Proxy for the `update_option` function.
	 *
	 * @see update_option()
	 *
	 * @param string $option
	 * @param mixed $value
	 * @param string|bool $autoload
	 */
	public function update_option($option, $value, $autoload = null) {
		return update_option($option, $value, $autoload);
	}
}