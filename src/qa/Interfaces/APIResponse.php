<?php


interface qa_Interfaces_APIResponse {

	/**
	 * Serves the plugin API responses returning HTML markup in place of JSON.
	 *
	 * @param bool             $served
	 * @param WP_REST_Response $response
	 * @param WP_REST_Request  $request
	 *
	 * @return bool Whether the response was served or not.
	 */
	public function serve( $served, WP_REST_Response $response, WP_REST_Request $request );
}