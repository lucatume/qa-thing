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
	public function __($text, $domain = 'default');

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
	public function current_user_can($capability);

	/**
	 * Proxy for the `add_action` function.
	 *
	 * @see add_action()
	 *
	 * @param $tag
	 * @param $function_to_add
	 * @param int $priority
	 * @param int $accepted_args
	 *
	 * @return bool
	 */
	public function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1);
}