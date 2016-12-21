<?php


interface qa_Interfaces_Endpoint {

	/**
	 * Registers the REST API endpoint.
	 *
	 * @param string $namespace The plugin API namespace.
	 *
	 * @return bool Whether the endpoint registration was successful or not.
	 */
	public function register( $namespace );

	/**
	 * @return string
	 */
	public function getRoute();

	/**
	 * @param string $route
	 */
	public function setRoute( $route );
}