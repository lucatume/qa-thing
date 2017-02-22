<?php

namespace qa\Ajax;

include_once codecept_data_dir('classes/WP_Ajax_Response.php');

use Prophecy\Argument;
use qa_Adapters_WordPressI as WP;
use qa_Ajax_ConfigurationApplyHandler as Handler;
use qa_Configurations_ScannerI as Scanner;

class HandlerTest extends \Codeception\Test\Unit {
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	/**
	 * @var Scanner
	 */
	protected $scanner;

	/**
	 * @var WP
	 */
	protected $wp;

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();

		$this->assertInstanceOf(Handler::class, $sut);
	}

	/**
	 * @return Handler
	 */
	private function make_instance() {
		return new Handler($this->scanner->reveal(), $this->wp->reveal());
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
		$this->wp->current_user_can('manage_options')->willReturn(false);
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
		$this->wp->current_user_can('manage_options')->willReturn(true);
		$this->scanner->getConfigurationById('foo::bar')->willReturn(false);
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
		$this->wp->current_user_can('manage_options')->willReturn(true);
		$configuration = $this->prophesize(\qa_Configurations_ConfigurationI::class);
		$configuration->apply()->willReturn(0);
		$this->scanner->getConfigurationById('foo::bar')->willReturn($configuration->reveal());
		$_POST['id'] = 'foo::bar';

		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_Response::class, $response);
	}

	/**
	 * @test
	 * it should return success response if configuration application was not successful
	 */
	public function it_should_return_success_response_if_configuration_application_was_not_successful() {
		$this->wp->current_user_can('manage_options')->willReturn(true);
		$configuration = $this->prophesize(\qa_Configurations_ConfigurationI::class);
		$configuration->apply()->willReturn(1);
		$this->scanner->getConfigurationById('foo::bar')->willReturn($configuration->reveal());
		$_POST['id'] = 'foo::bar';

		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_Response::class, $response);
	}

	/**
	 * @test
	 * it should return internal error response if configuration application generated an error
	 */
	public function it_should_return_internal_error_response_if_configuration_application_generated_an_error() {
		$this->wp->current_user_can('manage_options')->willReturn(true);
		$configuration = $this->prophesize(\qa_Configurations_ConfigurationI::class);
		$configuration->apply()->willThrow(new \RuntimeException());
		$this->scanner->getConfigurationById('foo::bar')->willReturn($configuration->reveal());
		$_POST['id'] = 'foo::bar';

		$handler = $this->make_instance();
		$response = $handler->handle(false);

		$this->assertInstanceOf(\qa_Ajax_InternalErrorResponse::class, $response);
	}

	protected function _before() {
		$this->scanner = $this->prophesize(Scanner::class);
		$this->wp = $this->prophesize(WP::class);
		$this->wp->__(Argument::type('string'), Argument::type('string'))->willReturn('foo');
		$this->wp->update_option(Argument::type('string'), Argument::any())->willReturn(true);
	}

	protected function _after() {
	}
}