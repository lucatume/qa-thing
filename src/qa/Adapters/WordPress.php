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

	/**
	 * Proxy for the `__` function.
	 *
	 * @see __()
	 *
	 * @param string $text
	 * @param string $domain
	 * @return string
	 */
	public function __($text, $domain = 'default') {
		return __($text, $domain);
	}

	/**
	 * Proxy for `wp_die` function.
	 *
	 * @see wp_die()
	 *
	 * @param string $message
	 * @param string $title
	 * @param array $args
	 */
	public function die($message = '', $title = '', $args = array()) {
		wp_die($message, $title, $args);
	}

	/**
	 * Proxy for the `current_user_can` function.
	 *
	 * @see current_user_can()
	 *
	 * @param string $capability
	 * @param int $object_id Optional. ID of the specific object to check against if `$capability` is a "meta" cap.
	 *                           "Meta" capabilities, e.g. 'edit_post', 'edit_user', etc., are capabilities used
	 *                           by map_meta_cap() to map to other "primitive" capabilities, e.g. 'edit_posts',
	 *                           'edit_others_posts', etc. Accessed via func_get_args() and passed to WP_User::has_cap(),
	 *                           then map_meta_cap().
	 *
	 * @return bool
	 */
	public function current_user_can($capability) {
		return current_user_can($capability);
	}
}