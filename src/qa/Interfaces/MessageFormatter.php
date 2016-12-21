<?php


interface qa_Interfaces_MessageFormatter {

	/**
	 * Formats a message to render like an error.
	 *
	 * @param string|array $message
	 *
	 * @return string
	 */
	public function formatError( $message );

	/**
	 * Formats a message to render like a success.
	 *
	 * @param string|array $message
	 *
	 * @return string
	 */
	public function formatSuccess( $message );

	/**
	 * Formats a message to render like an information.
	 *
	 * @param string|array $message
	 *
	 * @return string
	 */
	public function formatInformation( $message );

	/**
	 * Formats a message to render like an notice.
	 *
	 * @param string|array $message
	 *
	 * @return string
	 */
	public function formatNotice( $message );
}