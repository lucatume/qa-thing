<?php

namespace qa\Configurations;

use qa\Integration\TestCase;
use qa_Configurations_ConfigurationI as Configuration;
use qa_Configurations_Scanner as Scanner;

class ScannerTest extends TestCase {
	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$scanner = $this->make_instance();

		$this->assertInstanceOf(Scanner::class, $scanner);
	}

	/**
	 * @return Scanner
	 */
	private function make_instance() {
		return $this->container->make(Scanner::class);
	}

	/**
	 * @test
	 * it should return the plugin example configurations if no other plugin provides them
	 */
	public function it_should_return_the_pluging_example_configurations_if_no_other_plugin_provides_them() {
		$scanner = $this->make_instance();

		$this->assertCount(3, $scanner->configurations());
	}

	/**
	 * @test
	 * it should not provide the plugin example configurations if disabled via option
	 */
	public function it_should_not_provide_the_plugin_example_configurations_if_disabled_via_option() {
		update_option($this->container->getVar('options.option'), ['disable-examples' => true]);

		$scanner = $this->make_instance();

		$this->assertEmpty($scanner->configurations());
	}

	/**
	 * @test
	 * it should show additional configurations provided by a second plugin
	 */
	public function it_should_show_additional_configurations_provided_by_a_second_plugin() {
		update_option($this->container->getVar('options.option'), ['disable-examples' => true]);
		$this->copyDir(codecept_data_dir('plugins/one-configuration'), trailingslashit(WP_PLUGIN_DIR) . 'one');

		$scanner = $this->make_instance();
		$configurations = $scanner->configurations();

		$this->assertCount(1, $configurations);
		$this->assertEquals('one::one', $configurations[0]->id());
	}


	/**
	 * @test
	 * it should show additional configurations provided by more plugins
	 */
	public function it_should_show_additional_configurations_provided_by_more_plugins() {
		update_option($this->container->getVar('options.option'), ['disable-examples' => true]);
		$this->copyDir(codecept_data_dir('plugins/one-configuration'), trailingslashit(WP_PLUGIN_DIR) . 'one');
		$this->copyDir(codecept_data_dir('plugins/two-configurations'), trailingslashit(WP_PLUGIN_DIR) . 'two');
		$this->copyDir(codecept_data_dir('plugins/three-configurations'), trailingslashit(WP_PLUGIN_DIR) . 'three');

		$scanner = $this->make_instance();
		$configurations = $scanner->configurations();

		$this->assertCount(6, $configurations);
		$expected = ['one::one', 'two::one', 'two::two', 'three::one', 'three::two', 'three::three'];
		$read = array_map(function (Configuration $conf) {
			return $conf->id();
		}, $configurations);
		$this->assertEqualSets($expected, $read);
	}

	/**
	 * @test
	 * it should provide example configurations if not disabled alongside other plugins
	 */
	public function it_should_provide_example_configurations_if_not_disabled_alongside_other_plugins() {
		$this->copyDir(codecept_data_dir('plugins/one-configuration'), trailingslashit(WP_PLUGIN_DIR) . 'one');
		$this->copyDir(codecept_data_dir('plugins/two-configurations'), trailingslashit(WP_PLUGIN_DIR) . 'two');
		$this->copyDir(codecept_data_dir('plugins/three-configurations'), trailingslashit(WP_PLUGIN_DIR) . 'three');

		$scanner = $this->make_instance();
		$configurations = $scanner->configurations();

		$this->assertCount(9, $configurations);
		$expected = [
			'one::one',
			'two::one',
			'two::two',
			'three::one',
			'three::two',
			'three::three',
			'qa-thing::example',
			'qa-thing::failing-example',
			'qa-thing::fatal-example'
		];
		$read = array_map(function (Configuration $conf) {
			return $conf->id();
		}, $configurations);
		$this->assertEqualSets($expected, $read);
	}

	/**
	 * @test
	 * it should allow getting a configuration by id
	 */
	public function it_should_allow_getting_a_configuration_by_id() {
		$this->copyDir(codecept_data_dir('plugins/one-configuration'), trailingslashit(WP_PLUGIN_DIR) . 'one');

		$scanner = $this->make_instance();

		$config = $scanner->getConfigurationById('one::one');

		$this->assertNotEmpty($config);
		$this->assertEquals('Example', $config->name());
		$this->assertEquals('one::one', $config->id());
	}

	/**
	 * @test
	 * it should return false if trying to get non existing configuration by id
	 */
	public function it_should_return_false_if_trying_to_get_non_existing_configuration_by_id() {
		$scanner = $this->make_instance();

		$this->assertFalse($scanner->getConfigurationById('one::one'));
	}

}