<?php

namespace qa\Options;


use Prophecy\Argument;

class PageTest extends \Codeception\Test\Unit {
	protected $backupGlobals = false;
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

	/**
	 * @var \qa_Adapters_WordPressI
	 */
	protected $wp;

	protected function _before() {
		$this->renderEngine = $this->prophesize(\qa_RenderEngines_HandlebarsI::class);
		$this->scanner = $this->prophesize(\qa_Configurations_ScannerI::class);
		$this->wp = $this->prophesize(\qa_Adapters_WordPressI::class);
		$this->wp->__(Argument::type('string'), Argument::type('string'))->will(function ($args) {
			return $args[0];
		});
	}

	protected function _after() {
	}

	/**
	 * @test
	 * it should delegate render to Handlebars
	 */
	public function it_should_delegate_render_to_handlebars() {
		$this->scanner->configurations()->willReturn(['foo' => 'bar']);
		$this->renderEngine->render('options-page', Argument::type('array'))->shouldBeCalled();

		$page = new \qa_Options_Page('foo', $this->scanner->reveal(), $this->renderEngine->reveal(),
			$this->wp->reveal());

		$page->render();
	}
}