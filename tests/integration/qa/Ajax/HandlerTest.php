<?php

namespace qa\Ajax;

use qa\Integration\TestCase;
use qa_Ajax_ConfigurationApplyHandler as Handler;
use qa_Plugin as Plugin;

class HandlerTest extends TestCase {
	/**
	 * @var \tad_DI52_ContainerInterface
	 */
	protected $container;

	public function setUp() {
		// before
		parent::setUp();

		// your set up methods here
		$this->container = Plugin::getContainer();
	}

	public function tearDown() {
		// your tear down methods here
		foreach (['one', 'two', 'three'] as $dir) {
			$this->rmdir(trailingslashit(WP_PLUGIN_DIR) . $dir);
		}

		// then
		parent::tearDown();
	}

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();

		$this->assertInstanceOf(Handler::class, $sut);
	}

	/**
	 * @test
	 * it should return a bad request response if the configuration id is missing from $_POST
	 */
	public function it_should_return_a_bad_request_response_if_the_configuration_id_is_missing_from_post() {
		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_BadRequestResponse::class, $response);
	}

	public function badIds() {
		return [
			['foo'],
			['23'],
			['foo baz'],
			[new \stdClass()],
			[[]],
		];
	}

	/**
	 * @test
	 * it should return bad response if id in $_POST is not a valid string
	 * @dataProvider  badIds
	 */
	public function it_should_return_bad_response_if_id_in_post_is_not_a_valid_string($badId) {
		$_POST['id'] = $badId;

		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_BadRequestResponse::class, $response);
	}

	/**
	 * @test
	 * it should return invalid auth if current user cannot manage options
	 */
	public function it_should_return_invalid_auth_if_current_user_cannot_manage_options() {
		wp_set_current_user($this->factory()->user->create(['role' => 'subscriber']));
		$_POST['id'] = 'foo::bar';

		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_InvalidAuthResponse::class, $response);
	}

	/**
	 * @test
	 * it should return bad request if configuration was not found for id
	 */
	public function it_should_return_bad_request_if_configuration_was_not_found_for_id() {
		wp_set_current_user($this->factory()->user->create(['role' => 'administrator']));
		$_POST['id'] = 'foo::bar';

		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_BadRequestResponse::class, $response);
	}

	/**
	 * @test
	 * it should return success response if configuration application was successful
	 */
	public function it_should_return_success_response_if_configuration_application_was_successful() {
		wp_set_current_user($this->factory()->user->create(['role' => 'administrator']));
		$this->copyDir(codecept_data_dir('plugins/scripts-one'), trailingslashit(WP_PLUGIN_DIR) . 'one');
		$_POST['id'] = 'scripts-one::success';

		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_Response::class, $response);
	}

	/**
	 * @test
	 * it should return success response if configuration application was not successful
	 */
	public function it_should_return_success_response_if_configuration_application_was_not_successful() {
		wp_set_current_user($this->factory()->user->create(['role' => 'administrator']));
		$this->copyDir(codecept_data_dir('plugins/scripts-one'), trailingslashit(WP_PLUGIN_DIR) . 'one');
		$_POST['id'] = 'scripts-one::failure';

		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_Response::class, $response);
	}

	/**
	 * @test
	 * it should return internal error response if configuration application generated an error
	 */
	public function it_should_return_internal_error_response_if_configuration_application_generated_an_error() {
		wp_set_current_user($this->factory()->user->create(['role' => 'administrator']));
		$this->copyDir(codecept_data_dir('plugins/scripts-one'), trailingslashit(WP_PLUGIN_DIR) . 'one');
		$_POST['id'] = 'scripts-one::error';

		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_Response::class, $response);
	}

	/**
	 * @return Handler
	 */
	private function make_instance() {
		return $this->container->make(Handler::class);
	}
}