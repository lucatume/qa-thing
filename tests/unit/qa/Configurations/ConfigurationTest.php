<?php

namespace qa\Configurations;

use qa_Configurations_Configuration as Configuration;

class ConfigurationTest extends \Codeception\Test\Unit {
	protected $backupGlobals = false;
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before() {
	}

	protected function _after() {
	}

	/**
	 * @test
	 * it should throw if slug is missing from pluginData
	 */
	public function it_should_throw_if_slug_is_missing_from_plugin_data() {
		$this->setExpectedException(\InvalidArgumentException::class);

		new Configuration('foo', ['title' => 'foo', 'target' => 'some-script.php'], ['foo' => 'bar']);
	}

	/**
	 * @test
	 * it should throw if title is missing from configuration
	 */
	public function it_should_throw_if_title_is_missing_from_configuration() {
		$this->setExpectedException(\InvalidArgumentException::class);

		new Configuration('foo', ['target' => 'some-script.php'], ['slug' => 'foo']);
	}

	/**
	 * @test
	 * it should throw if title is not string-able
	 */
	public function it_should_throw_if_title_is_not_string_able() {
		$this->setExpectedException(\InvalidArgumentException::class);

		new Configuration('foo', ['title' => ['foo' => 'bar'], 'target' => 'some-script.php'], ['slug' => 'foo']);
	}

	/**
	 * @test
	 * it should throw if target is missing from configuration
	 */
	public function it_should_throw_if_target_is_missing_from_configuration() {
		$this->setExpectedException(\InvalidArgumentException::class);

		new Configuration('foo', ['title' => 'foo'], ['slug' => 'foo']);
	}

	/**
	 * @test
	 * it should throw if target is not a string, an object or an array
	 */
	public function it_should_throw_if_target_is_not_a_string_an_object_or_an_array() {
		$this->setExpectedException(\InvalidArgumentException::class);

		new Configuration('foo', ['title' => 'foo', 'target' => null], ['slug' => 'foo']);
	}

	/**
	 * @test
	 * it should throw if target is array-able but empty
	 */
	public function it_should_throw_if_target_is_array_able_but_empty() {
		$this->setExpectedException(\InvalidArgumentException::class);

		new Configuration('foo', ['title' => 'foo', 'target' => []], ['slug' => 'foo']);
	}

	/**
	 * @test
	 * it should allow for array-able target formats
	 */
	public function it_should_allow_for_array_able_target_formats() {
		new Configuration('foo', ['title' => 'foo', 'target' => ['foo-script.php', 'bar-script.php']],
			['slug' => 'foo']);
		new Configuration('foo',
			['title' => 'foo', 'target' => (object)['foo' => 'foo-script.php', 'bar' => 'bar-script.php']],
			['slug' => 'foo']);
		new Configuration('foo', ['title' => 'foo', 'target' => 'foo-script.php'], ['slug' => 'foo']);
	}
}
