<?php

use function tad\WPBrowser\Tests\Support\rrmdir;

class PluginConfigurationReadCest {
	/**
	 * @var string
	 */
	protected $acmePlugin;

	/**
	 * @var string
	 */
	protected $qaFolder;

	public function _before(FunctionalTester $I) {
		$this->acmePlugin = $I->getWpRootFolder() . '/wp-content/plugins/acme';
		rrmdir($this->acmePlugin);
		$I->cli('scaffold plugin acme');
		$this->qaFolder = $this->acmePlugin . '/qa';
	}

	public function _after(FunctionalTester $I) {
		rrmdir($this->acmePlugin);
	}

	/**
	 * I can see a plugin provided configuration on the options page
	 */
	public function test_i_can_see_a_plugin_provided_configuration_on_the_options_page(FunctionalTester $I) {
		$I->copyDir(codecept_data_dir('configurations/one-configuration'), $this->qaFolder);
		$I->seeFileFound($this->qaFolder . '/qa-config.json');

		$I->loginAsAdmin();
		$I->amOnAdminPage('/admin.php?page=qa-options');

		$I->canSeeNumberOfElements('#qa-configuration option', 4);
	}

	/**
	 * @test
	 * it should not show example configurations if disabled
	 */
	public function it_should_not_show_example_configurations_if_disabled(FunctionalTester $I) {
		$I->copyDir(codecept_data_dir('configurations/one-configuration'), $this->qaFolder);
		$I->seeFileFound($this->qaFolder . '/qa-config.json');
		$I->haveOptionInDatabase('qa-thing', ['disable-examples' => true]);

		$I->loginAsAdmin();
		$I->amOnAdminPage('/admin.php?page=qa-options');

		$I->canSeeNumberOfElements('#qa-configuration option', 1);
	}
}
