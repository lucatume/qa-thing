<?php

namespace qa\Integration;

use Codeception\TestCase\WPTestCase;
use qa_Plugin as Plugin;

class TestCase extends WPTestCase {

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

	function rmdir($path) {
		exec("rm -rf $path");
	}

	/**
	 * @param $src
	 * @param $dest
	 */
	protected function copyDir($src, $dest) {
		exec("cp -r $src $dest");
	}
}