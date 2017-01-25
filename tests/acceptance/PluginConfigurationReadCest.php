<?php


class PluginConfigurationReadCest {
	public function _before( AcceptanceTester $I ) {
		$I->cli('plugin delete acme');
	}

	public function _after( AcceptanceTester $I ) {
		$I->cli('plugin delete acme');
	}

	/**
	 * I can see a plugin provided configuration on the options page
	 */
	public function test_i_can_see_a_plugin_provided_configuration_on_the_options_page( AcceptanceTester $I ) {
		$I->am( 'QA person' );
		$I->wantTo( 'see a plugin provided configuration' );

		$I->cli( 'scaffold plugin acme' );
		$pluginPath = $I->cli( 'plugin path acme --dir' );

		$destination = $pluginPath . '/qa';
		$I->copyDir( codecept_data_dir( 'configurations/one-configuration' ), $destination );

		$I->seeFileFound( $destination );
	}
}
