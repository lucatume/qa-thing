<?php


class qa_Endpoints_IssuesConfigurationApply implements qa_Interfaces_Endpoint {

	/**
	 * @var string
	 */
	protected $route = 'issues/configuration/apply';
	/**
	 * @var qa_Interfaces_IssueConfigurationApplication
	 */
	protected $issueConfiguration;
	/**
	 * @var qa_Interfaces_IssueRepository
	 */
	protected $repository;
	/**
	 * @var qa_Interfaces_APIResponse
	 */
	protected $formatter;

	/**
	 * qa_Endpoints_IssuesConfigurationApply constructor.
	 *
	 * @param qa_Interfaces_IssueConfigurationApplication $issueConfiguration
	 * @param qa_Interfaces_IssueRepository               $repository
	 * @param qa_Interfaces_MessageFormatter              $formatter
	 */
	public function __construct(
		qa_Interfaces_IssueConfigurationApplication $issueConfiguration,
		qa_Interfaces_IssueRepository $repository,
		qa_Interfaces_MessageFormatter $formatter
	) {
		$this->issueConfiguration = $issueConfiguration;
		$this->repository         = $repository;
		$this->formatter          = $formatter;
	}

	/**
	 * Registers the REST API endpoint.
	 *
	 * @param string $namespace
	 *
	 * @return bool Whether the endpoint registration was successful or not.
	 */
	public function register( $namespace ) {
		return register_rest_route( $namespace, $this->route, array(
			'methods'  => 'POST',
			'callback' => array( $this, 'applyConfiguration' )
		) );
	}

	/**
	 * @return string
	 */
	public function getRoute() {
		return $this->route;
	}

	/**
	 * @param string $route
	 */
	public function setRoute( $route ) {
		$this->route = $route;
	}

	public function applyConfiguration( WP_REST_Request $request ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return $this->cancelPolling( $this->formatter->formatError( 'User not authorized to apply configurations.' ) );
		}

		$requestConfig = $request->get_param( 'qa-configuration' );

		if ( empty( $requestConfig ) ) {
			$this->cancelPolling( $this->formatter->formatError( __( 'Issue configuration not specified.' ) ) );
		}

		try {
			$configuration = new qa_Issues_Config( $this->repository->readConfigFor( $requestConfig ) );

			return $this->issueConfiguration->apply( $configuration );
		} catch ( Exception $e ) {
			return $this->cancelPolling( $this->formatter->formatError( $e->getMessage() ) );
		}
	}

	/**
	 * @param string $message
	 *
	 * @return WP_REST_Response
	 */
	protected function cancelPolling( $message = '' ) {
		$response = new WP_REST_Response( $message );
		$response->set_status( 200 );
		$response->header( 'X-IC-CancelPolling', 'true' );

		return $response;
	}
}