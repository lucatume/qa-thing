<?php

interface qa_Interfaces_MessageFormatter {

	/**
	 * Formats a message to render like an error.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatError( $message );

	/**
	 * Formats a message to render like a success.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatSuccess( $message );

	/**
	 * Formats a message to render like an information.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatInformation( $message );

	/**
	 * Formats a message to render like an notice.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatNotice( $message );
}