<?php

namespace qa\Configurations;

use org\bovigo\vfs\vfsStream;
use Prophecy\Argument;
use qa_Configurations_Scanner as Scanner;
use function GuzzleHttp\json_encode;

class ScannerTest extends \Codeception\Test\Unit {
	protected $backupGlobals = false;
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	/**
	 * @var \qa_Adapters_WordPressI
	 */
	protected $wp;

	/**
	 * @var \qa_Options_RepositoryI
	 */
	protected $options;

	protected function _before() {
		$this->options = $this->prophesize(\qa_Options_RepositoryI::class);
		// disable them by default
		$this->options->disableExamples()->willReturn(true);
		$this->wp = $this->prophesize(\qa_Adapters_WordPressI::class);
	}

	protected function _after() {
	}

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();

		$this->assertInstanceOf(Scanner::class, $sut);
	}

	/**
	 * @return Scanner
	 */
	private function make_instance() {
		return new Scanner($this->wp->reveal(), $this->options->reveal());
	}

	/**
	 * @test
	 * it should return no configurations if there are no plugins installed
	 */
	public function it_should_return_no_configurations_if_there_are_no_plugins_installed() {
		$this->options->read()->shouldBeCalled();
		$this->wp->get_plugins()->willReturn([]);

		$scanner = $this->make_instance();

		$this->assertEmpty($scanner->configurations());
	}

	/**
	 * @test
	 * it should return no configurations if there is one plugin installed but has no configurations
	 */
	public function it_should_return_no_configurations_if_there_is_one_plugin_installed_but_has_no_configurations() {
		$this->options->read()->shouldBeCalled();
		$plugins = [
			'foo/foo.php' => ['Title' => 'foo']
		];
		$root = vfsStream::setup('plugins', 777, [
			'foo' => [
				'foo.php' => '<?php // Silence is golden ?>'
			]
		]);
		$this->wp->get_plugins()->willReturn($plugins);
		$this->wp->plugin_dir('foo/foo.php')->willReturn($root->url() . '/foo/foo.php');

		$scanner = $this->make_instance();

		$this->assertEmpty($scanner->configurations());
	}

	/**
	 * @test
	 * it should return one configuration if there is a plugin with a configuration file
	 */
	public function it_should_return_one_configuration_if_there_is_a_plugin_with_a_configuration_file() {
		$this->options->read()->shouldBeCalled();
		$plugins = [
			'bar/bar.php' => ['Title' => 'bar']
		];
		$root = vfsStream::setup('plugins', 777, [
			'bar' => [
				'bar.php' => '<?php // Silence is golden ?>',
				'qa' => [
					'qa-config.json' => file_get_contents(codecept_data_dir('configurations/one-configuration.json'))
				]
			]
		]);
		$this->wp->get_plugins()->willReturn($plugins);
		$this->wp->plugin_dir(Argument::type('string'))->will(function (array $args) use ($root) {
			return $root->url() . DIRECTORY_SEPARATOR . $args[0];
		});

		$scanner = $this->make_instance();
		$configurations = $scanner->configurations();

		$this->assertNotEmpty($configurations);
		$this->assertCount(1, $configurations);
	}

	/**
	 * @test
	 * it should return one configuration if there are two plugins but only one has a valid configuration
	 */
	public function it_should_return_one_configuration_if_there_are_two_plugins_but_only_one_has_a_valid_configuration(
	) {
		$this->options->read()->shouldBeCalled();
		$plugins = [
			'foo/foo.php' => ['Title' => 'foo'],
			'bar/bar.php' => ['Title' => 'bar']
		];
		$root = vfsStream::setup('plugins', 777, [
			'foo' => [
				'foo.php' => '<?php // Silence is golden ?>'
			],
			'bar' => [
				'bar.php' => '<?php // Silence is golden ?>',
				'qa' => [
					'qa-config.json' => file_get_contents(codecept_data_dir('configurations/one-configuration.json'))
				]
			]
		]);
		$this->wp->get_plugins()->willReturn($plugins);
		$this->wp->plugin_dir(Argument::type('string'))->will(function (array $args) use ($root) {
			return $root->url() . DIRECTORY_SEPARATOR . $args[0];
		});

		$scanner = $this->make_instance();
		$configurations = $scanner->configurations();

		$this->assertNotEmpty($configurations);
		$this->assertCount(1, $configurations);
	}

	public function invalidConfigurations() {
		return [
			[json_encode([])],
			[json_encode(['configurations' => []])],
			// missing title
			[json_encode(['configurations' => ['foo' => ['target' => 'some-script.php']]])],
			// missing target
			[json_encode(['configurations' => ['foo' => ['title' => 'some title']]])],
		];
	}

	/**
	 * @test
	 * it should prune invalid configurations
	 * @dataProvider invalidConfigurations
	 */
	public function it_should_prune_invalid_configurations($invalid) {
		$this->options->read()->shouldBeCalled();
		$plugins = [
			'bar/bar.php' => ['Title' => 'bar']
		];
		$root = vfsStream::setup('plugins', 777, [
			'bar' => [
				'bar.php' => '<?php // Silence is golden ?>',
				'qa' => [
					'qa-config.json' => $invalid
				]
			]
		]);
		$this->wp->get_plugins()->willReturn($plugins);
		$this->wp->plugin_dir(Argument::type('string'))->will(function (array $args) use ($root) {
			return $root->url() . DIRECTORY_SEPARATOR . $args[0];
		});

		$scanner = $this->make_instance();

		$this->assertEmpty($scanner->configurations());
	}

	/**
	 * @test
	 * it should exclude not the plugin examples if option is not set
	 */
	public function it_should_exclude_not_the_plugin_examples_if_option_is_not_set() {
		$this->options->disableExamples()->willReturn(false);
		$this->options->read()->shouldBeCalled();
		$plugins = [
			'foo/foo.php' => ['Title' => 'foo'],
			'bar/bar.php' => ['Title' => 'bar'],
			'qa-thing/qa-thing.php' => ['Title' => 'qa-thing'],
		];
		$root = vfsStream::setup('plugins', 777, [
			'foo' => [
				'foo.php' => '<?php // Silence is golden ?>'
			],
			'bar' => [
				'bar.php' => '<?php // Silence is golden ?>',
				'qa' => [
					'qa-config.json' => file_get_contents(codecept_data_dir('configurations/one-configuration.json'))
				]
			],
			'qa-thing' => [
				'qa-thing.php' => '<?php // Silence is golden ?>',
				'qa' => [
					'qa-config.json' => file_get_contents(codecept_root_dir('qa/qa-config.json'))
				]
			]
		]);
		$this->wp->get_plugins()->willReturn($plugins);
		$this->wp->plugin_dir(Argument::type('string'))->will(function (array $args) use ($root) {
			return $root->url() . DIRECTORY_SEPARATOR . $args[0];
		});

		$scanner = $this->make_instance();
		$configurations = $scanner->configurations();

		$this->assertNotEmpty($configurations);
		$this->assertCount(4, $configurations);
	}

	/**
	 * @test
	 * it should allow getting a configuration by id
	 */
	public function it_should_allow_getting_a_configuration_by_id() {
		$fooConfigurations = [
			'configurations' => [
				'bar' => [
					'title' => 'Bar',
					'target' => 'qa/scripts/bar.php',
				],
				'baz' => [
					'title' => 'Baz',
					'target' => 'qa/scripts/baz.php',
				]
			]
		];

		$this->options->read()->shouldBeCalled();
		$plugins = [
			'foo/foo.php' => ['Title' => 'foo']
		];
		$root = vfsStream::setup('plugins', 777, [
			'foo' => [
				'foo.php' => '<?php // Silence is golden ?>',
				'qa' => [
					'qa-config.json' => json_encode($fooConfigurations)
				]
			]
		]);
		$this->wp->get_plugins()->willReturn($plugins);
		$this->wp->plugin_dir(Argument::type('string'))->will(function (array $args) use ($root) {
			return $root->url() . DIRECTORY_SEPARATOR . $args[0];
		});

		$scanner = $this->make_instance();

		$barConfig = $scanner->getConfigurationById('foo::bar');

		$this->assertNotEmpty($barConfig);
		$this->assertEquals('Bar', $barConfig->name());
		$this->assertEquals('foo::bar', $barConfig->id());

		$bazConfig = $scanner->getConfigurationById('foo::baz');

		$this->assertNotEmpty($bazConfig);
		$this->assertEquals('Baz', $bazConfig->name());
		$this->assertEquals('foo::baz', $bazConfig->id());
	}

	/**
	 * @test
	 * it should return false if trying to get non existing configuration by id
	 */
	public function it_should_return_false_if_trying_to_get_non_existing_configuration_by_id() {
		$fooConfigurations = [
			'configurations' => [
				'bar' => [
					'title' => 'Bar',
					'target' => 'qa/scripts/bar.php',
				],
				'baz' => [
					'title' => 'Baz',
					'target' => 'qa/scripts/baz.php',
				]
			]
		];

		$this->options->read()->shouldBeCalled();
		$plugins = [
			'foo/foo.php' => ['Title' => 'foo']
		];
		$root = vfsStream::setup('plugins', 777, [
			'foo' => [
				'foo.php' => '<?php // Silence is golden ?>',
				'qa' => [
					'qa-config.json' => json_encode($fooConfigurations)
				]
			]
		]);
		$this->wp->get_plugins()->willReturn($plugins);
		$this->wp->plugin_dir(Argument::type('string'))->will(function (array $args) use ($root) {
			return $root->url() . DIRECTORY_SEPARATOR . $args[0];
		});

		$scanner = $this->make_instance();

		$this->assertFalse($scanner->getConfigurationById('foo::some'));
	}
}