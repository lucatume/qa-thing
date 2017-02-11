<?php

use function tad\WPBrowser\Tests\Support\rrmdir;

class PluginConfigurationApplicationCest {

	/**
	 * @var string
	 */
	protected $pluginDir;

	public function _before(FunctionalTester $I) {
		$this->pluginDir = $I->getWpRootFolder() . '/wp-content/plugins/acme';
		rrmdir($this->pluginDir);
		$I->copyDir(codecept_data_dir('plugins/scripts-one'), $this->pluginDir);
	}

	public function _after(FunctionalTester $I) {
		rrmdir($this->pluginDir);
	}

	/**
	 * @test
	 * it should allow applying a successful configuration and see the success status
	 */
	public function it_should_allow_applying_a_successful_configuration_and_see_the_success_status(FunctionalTester $I
	) {
		$I->seeFileFound($this->pluginDir . '/qa/qa-config.json');

		$I->loginAsAdmin();
		$I->amOnAdminPage('/admin.php?page=qa-options');

		$I->sendAjaxPostRequest('/wp-admin/admin-ajax.php',
			['action' => 'qa_apply_configuration', 'id' => 'scripts-one::success']);

		$I->seeResponseCodeIs(200);

		$I->seeOptionInDatabase(['option_name' => 'qa-thing-last-run-status', 'option_value' => 'success']);
	}

	/**
	 * @test
	 * it should allow applying a failng configuration and see the failure status
	 */
	public function it_should_allow_applying_a_failng_configuration_and_see_the_failure_status(FunctionalTester $I) {
		$I->seeFileFound($this->pluginDir . '/qa/qa-config.json');

		$I->loginAsAdmin();
		$I->amOnAdminPage('/admin.php?page=qa-options');

		$I->sendAjaxPostRequest('/wp-admin/admin-ajax.php',
			['action' => 'qa_apply_configuration', 'id' => 'scripts-one::failure']);

		$I->seeResponseCodeIs(200);

		$I->seeOptionInDatabase(['option_name' => 'qa-thing-last-run-status', 'option_value' => 'fail']);
	}


	/**
	 * @test
	 * it should allow applying a configuration generating an error and see the error status
	 */
	public function it_should_allow_applying_a_configuration_generating_an_error_and_see_the_error_status(
		FunctionalTester $I
	) {
		$I->seeFileFound($this->pluginDir . '/qa/qa-config.json');

		$I->loginAsAdmin();
		$I->amOnAdminPage('/admin.php?page=qa-options');

		$I->sendAjaxPostRequest('/wp-admin/admin-ajax.php',
			['action' => 'qa_apply_configuration', 'id' => 'scripts-one::error']);

		$I->seeResponseCodeIs(200);

		$I->seeOptionInDatabase(['option_name' => 'qa-thing-last-run-status', 'option_value' => 'error']);
	}

	/**
	 * @test
	 * it should allow applying a configuration timing out and see the error status
	 */
	public function it_should_allow_applying_a_configuration_timing_out_and_see_the_error_status(FunctionalTester $I) {
	}

}
