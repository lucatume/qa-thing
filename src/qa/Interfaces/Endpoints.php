<?php


interface qa_Interfaces_Endpoints {

	/**
	 * @return string
	 */
	public function getApplyConfigurationUrl();

	/**
	 * @param string $key
	 *
	 * @return string
	 */
	public function getRouteFor( $key );

	/**
	 * @param string $key
	 * @param string $route
	 */
	public function setRouteFor( $key, $route );

	/**
	 * Checks whether the specified route is registered or not.
	 *
	 * @param string $route
	 *
	 * @return bool
	 */
	public function hasRoute( $route );
}