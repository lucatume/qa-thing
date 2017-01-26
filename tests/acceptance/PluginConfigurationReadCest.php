<?php


use Codeception\Exception\ModuleException;

class PluginConfigurationReadCest {
	public function _after( AcceptanceTester $I ) {
		try {
			$I->cli( 'plugin is-installed acme' );
			$I->cli( 'plugin delete acme' );
		} catch ( ModuleException $e ) {
			// not installed
		}
	}

	/**
	 * I can see a plugin provided configuration on the options page
	 */
	public function test_i_can_see_a_plugin_provided_configuration_on_the_options_page( AcceptanceTester $I ) {
		$I->am( 'QA person' );
		$I->wantTo( 'see a plugin provided configuration' );

		$I->cli( 'scaffold plugin acme' );

		$pluginPath = $I->cli( 'plugin path acme --dir' );
		$qaFolder = $pluginPath . '/qa';
		$I->copyDir( codecept_data_dir( 'configurations/one-configuration' ), $qaFolder );
		$I->seeFileFound( $qaFolder . '/qa-config.json' );

		$I->loginAsAdmin();
		$I->amOnAdminPage( '/admin.php?page=qa-options' );

		$I->canSeeNumberOfElements( '#qa-configuration option', 4 );
	}
}
