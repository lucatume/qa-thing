<?php


class qa_Utils_MessageFormatter implements qa_Interfaces_MessageFormatter {

	/**
	 * Formats a message to render like an error.
	 *
	 * @param string|array $message
	 *
	 * @return string
	 */
	public function formatError( $message ) {
		if ( is_array( $message ) ) {
			return implode( PHP_EOL, array_map( array( $this, 'formatError' ), $message ) );
		}

		return '<p class="qa-error">' . $message . '</p>';
	}

	/**
	 * Formats a message to render like a success.
	 *
	 * @param string|array $message
	 *
	 * @return string
	 */
	public function formatSuccess( $message ) {
		if ( is_array( $message ) ) {
			return implode( PHP_EOL, array_map( array( $this, 'formatSuccess' ), $message ) );
		}

		return '<p class="qa-success">' . $message . '</p>';
	}

	/**
	 * Formats a message to render like an information.
	 *
	 * @param string|array $message
	 *
	 * @return string
	 */
	public function formatInformation( $message ) {
		if ( is_array( $message ) ) {
			return implode( PHP_EOL, array_map( array( $this, 'formatInformation' ), $message ) );
		}

		return '<p class="qa-information">' . $message . '</p>';
	}

	/**
	 * Formats a message to render like an notice.
	 *
	 * @param string|array $message
	 *
	 * @return string
	 */
	public function formatNotice( $message ) {
		if ( is_array( $message ) ) {
			return implode( PHP_EOL, array_map( array( $this, 'formatNotice' ), $message ) );
		}

		return '<p class="qa-notice">' . $message . '</p>';
	}
}