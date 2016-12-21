<?php


class qa_Endpoints_Response implements qa_Interfaces_APIResponse {

	/**
	 * @var qa_Interfaces_Endpoints
	 */
	protected $endpoints;

	public function __construct( qa_Interfaces_Endpoints $endpoints ) {
		$this->endpoints = $endpoints;
	}

	/**
	 * Serves the plugin API responses returning HTML markup in place of JSON.
	 *
	 * @param bool             $served
	 * @param WP_REST_Response $response
	 * @param WP_REST_Request  $request
	 *
	 * @return bool Whether the response was served or not.
	 */
	public function serve( $served, WP_REST_Response $response, WP_REST_Request $request ) {
		if ( 'HEAD' === $request->get_method() ) {
			return false;
		}

		if ( ! $this->endpoints->hasRoute( $response->get_matched_route() ) ) {
			return false;
		}

		echo $response->get_data();

		return true;
	}

	/**
	 * Formats a message to render like an error.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatError( $message ) {
		return '<p class="qa-error">' . esc_html( $message ) . '</p>';
	}

	/**
	 * Formats a message to render like a success.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatSuccess( $message ) {
		return '<p class="qa-succes">' . esc_html( $message ) . '</p>';
	}

	/**
	 * Formats a message to render like an information.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatInformation( $message ) {
		return '<p class="qa-information">' . esc_html( $message ) . '</p>';
	}

	/**
	 * Formats a message to render like an notice.
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function formatNotice( $message ) {
		return '<p class="qa-notice">' . esc_html( $message ) . '</p>';
	}
}