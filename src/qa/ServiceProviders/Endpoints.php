<?php


class qa_ServiceProviders_Endpoints extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container['api-namespace'] = 'app/v1';

		$this->container->singleton( 'qa_Interfaces_IssueConfigurationApplication', 'qa_Issues_ConfigurationApplication' );
		$this->container->singleton( 'qa_Interfaces_Endpoints', array( $this, 'makeEndpointsInformation' ) );
		$this->container->singleton( 'qa_Interfaces_APIResponse', 'qa_Endpoints_Response' );

		$this->container->tag( array(
			'qa_Endpoints_IssuesConfigurationApply',
		), 'endpoints' );

		$this->container->make( 'qa_Interfaces_Endpoints' );

		add_action( 'rest_api_init', array( $this, 'registerRoutes' ) );
		add_filter( 'rest_pre_serve_request', array( $this->container->make( 'qa_Interfaces_APIResponse' ), 'serve' ), 20, 3 );
	}

	public function makeEndpointsInformation() {
		$endpoints = new qa_Endpoints_Information();

		foreach ( $this->container->tagged( 'endpoints' ) as $endpoint ) {
			/** @var qa_Interfaces_Endpoint $endpoint */
			$endpoints->setRouteFor( get_class( $endpoint ), $this->container['api-namespace'] . '/' . $endpoint->getRoute() );
		}

		return $endpoints;
	}

	public function registerRoutes() {
		$endpoints = $this->container->make( 'qa_Interfaces_Endpoints' );

		foreach ( $this->container->tagged( 'endpoints' ) as $endpoint ) {
			/** @var qa_Interfaces_Endpoint $endpoint */
			$endpoint->register( $this->container['api-namespace'] );
		}
	}

	/**
	 * Binds and sets up implementations at boot time.
	 */
	public function boot() {
		// no-op
	}
}