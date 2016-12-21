<?php


class qa_Endpoints_Information implements qa_Interfaces_Endpoints {

	/**
	 * @var array
	 */
	protected $routes = array();

	/**
	 * @return string
	 */
	public function getApplyConfigurationUrl() {
		return '/' . rest_get_url_prefix() . $this->getRouteFor( 'qa_Endpoints_IssuesConfigurationApply' );
	}

	/**
	 * @param string $key
	 *
	 * @return string
	 */
	public function getRouteFor( $key ) {
		if ( empty( $this->routes[ $key ] ) ) {
			return '';
		}

		return $this->routes[ $key ];
	}

	/**
	 * @param string $key
	 * @param string $route
	 */
	public function setRouteFor( $key, $route ) {
		$this->routes[ $key ] = '/' . trim( $route, '/' );
	}

	/**
	 * Checks whether the specified route is registered or not.
	 *
	 * @param string $route
	 *
	 * @return bool
	 */
	public function hasRoute( $route ) {
		return array_search( $route, $this->routes );
	}
}