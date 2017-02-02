<?php

namespace qa\Options;

use qa_Options_Repository as Repository;

class RepositoryTest extends \Codeception\Test\Unit {
	protected $backupGlobals = false;
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	/**
	 * @var \qa_Adapters_WordPressI
	 */
	protected $wp;

	protected function _before() {
		$this->wp = $this->prophesize(\qa_Adapters_WordPressI::class);
	}

	protected function _after() {
	}

	/**
	 * @test
	 * it should throw if option name is not a string
	 */
	public function it_should_throw_if_option_name_is_not_a_string() {
		$this->setExpectedException(\InvalidArgumentException::class);

		new Repository([234], $this->wp->reveal());
	}

	/**
	 * @test
	 * it should read option from database on build and dump on destruction
	 */
	public function it_should_read_option_from_database_on_build_and_dump_on_destruction() {
		$this->wp->get_option('foo')->shouldBeCalled();
		$this->wp->update_option('foo', [])->shouldBeCalled();

		new Repository('foo', $this->wp->reveal());
	}

	/**
	 * @test
	 * it should allow re-reading
	 */
	public function it_should_allow_re_reading() {
		$calls = 0;
		$this->wp->get_option('foo')->will(function () use (&$calls) {
			$map = [
				0 => [],
				1 => ['bar' => 'some']
			];

			return $map[$calls++];
		});
		$this->wp->update_option('foo', ['bar' => 'some'])->shouldBeCalled();

		$repository = new Repository('foo', $this->wp->reveal());

		$repository->read();

		$this->assertEquals('some', $repository['bar']);
	}

	/**
	 * @test
	 * it should allow updating
	 */
	public function it_should_allow_updating() {
		$this->wp->get_option('foo')->shouldBeCalled();
		$this->wp->update_option('foo', ['bar' => 'some'])->shouldBeCalledTimes(2);

		$repository = new Repository('foo', $this->wp->reveal());
		$repository['bar'] = 'some';

		$repository->update();
	}

	/**
	 * @test
	 * it should allow unsetting options
	 */
	public function it_should_allow_unsetting_options() {
		$this->wp->get_option('foo')->willReturn(['bar' => 'some']);
		$this->wp->update_option('foo', [])->shouldBeCalled();

		$repository = new Repository('foo', $this->wp->reveal());
		unset($repository['bar']);
	}

	/**
	 * @test
	 * it should allow checking for isset and empty
	 */
	public function it_should_allow_checking_for_isset_and_empty() {
		$this->wp->get_option('foo')->willReturn(['bar' => 'some']);
		$this->wp->update_option('foo', [])->shouldBeCalled();

		$repository = new Repository('foo', $this->wp->reveal());
		unset($repository['bar']);

		$this->assertFalse(isset($repository['bar']));
		$this->assertTrue(empty($repository['bar']));
	}
}