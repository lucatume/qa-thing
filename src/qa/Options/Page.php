<?php


class qa_Options_Page implements qa_Interfaces_OptionsPage {

	/**
	 * @var string
	 */
	protected $id = 'qa-options';

	/**
	 * @var string
	 */
	protected $group = 'qa';
	/**
	 * @var qa_Interfaces_RenderEngine
	 */
	protected $render_engine;
	/**
	 * @var qa_Interfaces_IssueRepository
	 */
	private $issue_repository;
	/**
	 * @var qa_Interfaces_Endpoints
	 */
	protected $endpoints;

	public function __construct(
		qa_Interfaces_IssueRepository $issue_repository,
		qa_Interfaces_RenderEngine $render_engine,
		qa_Interfaces_Endpoints $endpoints
	) {
		$this->render_engine    = $render_engine;
		$this->issue_repository = $issue_repository;
		$this->endpoints        = $endpoints;
	}

	/**
	 * Register the page.
	 *
	 * @return false|string The resulting page's hook_suffix, or false if the user does not have the capability required.
	 */
	public function register() {
		return add_menu_page( __( 'QA Thing', 'qa' ), __( 'QA Thing', 'qa' ), 'manage_options', $this->id, array( $this, 'render' ) );
	}

	/**
	 * Registers the page settings
	 */
	public function register_settings() {
		register_setting( $this->group, 'qa_issue_number' );
	}

	public function render() {
		$issues = $this->issue_repository->getAll();

		$data   = array(
			'title'          => __( 'QA All the Things', 'qa' ),
			'settingGroup'   => $this->group,
			'issues'         => $issues,
			'buttonClass' => empty($issues) ? 'disabled' : 'button-primary',
			'applyConfigUrl' => home_url( $this->endpoints->getApplyConfigurationUrl() )
		);

		wp_enqueue_style( 'qa-style' );
		wp_enqueue_script( 'qa-script' );
		wp_localize_script( 'qa-script', 'QA', array( 'nonce' => wp_create_nonce( 'wp_rest' ) ) );

		echo $this->render_engine->render( 'options-page', $data );
	}
}