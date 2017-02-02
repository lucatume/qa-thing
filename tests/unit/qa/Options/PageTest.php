<?php

namespace qa\Options;


class PageTest extends \Codeception\Test\Unit {
	/**
	 * @var \UnitTester
	 */
	protected $tester;
	/**
	 * @var \qa_RenderEngines_HandlebarsI
	 */
	protected $renderEngine;

	/**
	 * @var \qa_Configurations_ScannerI
	 */
	protected $scanner;

	protected function _before() {
		$this->renderEngine = $this->prophesize(\qa_RenderEngines_HandlebarsI::class);
		$this->scanner = $this->prophesize(\qa_Configurations_ScannerI::class);
	}

	protected function _after() {
	}

	/**
	 * @test
	 * it should delegate render to Handlebars
	 */
	public function it_should_delegate_render_to_handlebars() {
		$this->scanner->configurations()->willReturn(['foo' => 'bar']);
		$this->renderEngine->render('options-page', ['configurations' => ['foo' => 'bar']])->shouldBeCalled();

		$page = new \qa_Options_Page('foo', $this->scanner->reveal(), $this->renderEngine->reveal());

		$page->render();
	}
}