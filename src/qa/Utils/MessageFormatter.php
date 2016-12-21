<?php


class qa_Utils_MessageFormatter implements qa_Interfaces_MessageFormatter {

	/**
	 * Formats a message to render like an error.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatError( $message ) {
		return '<p class="qa-error">' . $message . '</p>';
	}

	/**
	 * Formats a message to render like a success.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatSuccess( $message ) {
		return '<p class="qa-success">' . $message . '</p>';
	}

	/**
	 * Formats a message to render like an information.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatInformation( $message ) {
		return '<p class="qa-information">' . $message . '</p>';
	}

	/**
	 * Formats a message to render like an notice.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatNotice( $message ) {
		return '<p class="qa-notice">' . $message . '</p>';
	}
}