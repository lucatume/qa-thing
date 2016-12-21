Feature: Manage WordPress plugins

  Scenario: Create, activate and check plugin status
    Given a WP install
    And I run `wp plugin path`
    And save STDOUT as {PLUGIN_DIR}

    When I run `wp plugin scaffold --skip-tests plugin1`
    Then STDOUT should not be empty
    And the {PLUGIN_DIR}/plugin1/plugin1.php file should exist
    And the {PLUGIN_DIR}/zombieland/phpunit.xml.dist file should not exist

    When I run `wp plugin path plugin1`
    Then STDOUT should be:
      """
      {PLUGIN_DIR}/plugin1/plugin1.php
      """

    When I run `wp plugin path plugin1 --dir`
    Then STDOUT should be:
      """
      {PLUGIN_DIR}/plugin1
      """

    When I run `wp plugin scaffold Zombieland`
    Then STDOUT should not be empty
    And the {PLUGIN_DIR}/Zombieland/Zombieland.php file should exist
    And the {PLUGIN_DIR}/Zombieland/phpunit.xml.dist file should exist

    # Ensure case sensitivity
    When I try `wp plugin status zombieLand`
    Then STDERR should contain:
      """
      The 'zombieLand' plugin could not be found.
      """

    # Check that the inner-plugin is not picked up
    When I run `mv {PLUGIN_DIR}/plugin1 {PLUGIN_DIR}/Zombieland/`
    And I run `wp plugin status Zombieland`
    Then STDOUT should contain:
      """
      Plugin Zombieland details:
          Name: Zombieland
          Status: Inactive
          Version: 0.1.0
          Author: YOUR NAME HERE
          Description: PLUGIN DESCRIPTION HERE
      """

    When I run `wp plugin activate Zombieland`
    Then STDOUT should not be empty

    When I run `wp plugin status Zombieland`
    Then STDOUT should contain:
      """
          Status: Active
      """

    When I run `wp plugin status`
    Then STDOUT should not be empty

    When I run `wp plugin list`
    Then STDOUT should be a table containing rows:
      | name       | status | update | version |
      | Zombieland | active | none   | 0.1.0   |

    When I try `wp plugin uninstall Zombieland`
    Then STDERR should contain:
      """
      The 'Zombieland' plugin is active.
      """

    When I run `wp plugin deactivate Zombieland`
    Then STDOUT should not be empty

    When I run `wp option get recently_activated`
    Then STDOUT should contain:
      """
      Zombieland/Zombieland.php
      """

    When I run `wp plugin uninstall Zombieland`
    Then STDOUT should contain:
      """
      Success: Uninstalled and deleted 'Zombieland' plugin.
      """
    And the {PLUGIN_DIR}/zombieland file should not exist

    When I try the previous command again
    Then STDERR should contain:
      """
      The 'Zombieland' plugin could not be found.
      """

  Scenario: Install a plugin, activate, then force install an older version of the plugin
    Given a WP install

    When I run `wp plugin install akismet --version=2.5.7 --force`
    Then STDOUT should not be empty

    When I run `wp plugin list --name=akismet --field=update_version`
    Then STDOUT should not be empty
    And save STDOUT as {UPDATE_VERSION}

    When I run `wp plugin list --fields=name,status,update,version,update_version`
    Then STDOUT should be a table containing rows:
      | name       | status   | update    | version   | update_version   |
      | akismet    | inactive | available | 2.5.7     | {UPDATE_VERSION} |

    When I run `wp plugin activate akismet`
    Then STDOUT should not be empty

    When I run `wp plugin install akismet --version=2.5.6 --force`
    Then STDOUT should not be empty

    When I run `wp plugin list`
    Then STDOUT should be a table containing rows:
      | name       | status   | update    | version   |
      | akismet    | active   | available | 2.5.6     |

    When I try `wp plugin update`
    Then STDERR should be:
      """
      Error: Please specify one or more plugins, or use --all.
      """

    When I run `wp plugin update --all --format=summary | grep 'updated successfully from'`
    Then STDOUT should contain:
      """
      Akismet updated successfully from version 2.5.6 to version
      """

  Scenario: Activate a network-only plugin on single site
    Given a WP install
    And a wp-content/plugins/network-only.php file:
      """
      // Plugin Name: Example Plugin
      // Network: true
      """

    When I run `wp plugin activate network-only`
    Then STDOUT should be:
      """
      Success: Plugin 'network-only' activated.
      """

    When I run `wp plugin status network-only`
    Then STDOUT should contain:
      """
          Status: Active
      """

  Scenario: Activate a network-only plugin on multisite
    Given a WP multisite install
    And a wp-content/plugins/network-only.php file:
      """
      // Plugin Name: Example Plugin
      // Network: true
      """

    When I run `wp plugin activate network-only`
    Then STDOUT should be:
      """
      Success: Plugin 'network-only' network activated.
      """

    When I run `wp plugin status network-only`
    Then STDOUT should contain:
      """
          Status: Network Active
      """

  Scenario: Network activate a plugin
    Given a WP multisite install

    When I run `wp plugin activate akismet`
    Then STDOUT should contain:
      """
      Success: Plugin 'akismet' activated.
      """

    When I run `wp plugin list --fields=name,status`
    Then STDOUT should be a table containing rows:
      | name            | status           |
      | akismet         | active           |

    When I run `wp plugin activate akismet`
    Then STDERR should contain:
      """
      Warning: Plugin 'akismet' is already active.
      """

    When I run `wp plugin activate akismet --network`
    Then STDOUT should contain:
      """
      Success: Plugin 'akismet' network activated.
      """

    When I run `wp plugin activate akismet --network`
    Then STDERR should contain:
      """
      Warning: Plugin 'akismet' is already network active.
      """

    When I run `wp plugin deactivate akismet`
    Then STDERR should contain:
      """
      Warning: Plugin 'akismet' is network active and must be deactivated with --network flag.
      """

    When I run `wp plugin deactivate akismet --network`
    Then STDOUT should contain:
      """
      Success: Plugin 'akismet' network deactivated.
      """

    When I run `wp plugin deactivate akismet`
    Then STDERR should contain:
      """
      Warning: Plugin 'akismet' isn't active.
      """

  Scenario: List plugins
    Given a WP install

    When I run `wp plugin activate akismet hello`
    Then STDOUT should not be empty

    When I run `wp plugin list --status=inactive --field=name`
    Then STDOUT should be empty

    When I run `wp plugin list --status=active --fields=name,status`
    Then STDOUT should be a table containing rows:
      | name       | status   |
      | akismet    | active   |

  Scenario: Install a plugin when directory doesn't yet exist
    Given a WP install

    When I run `rm -rf wp-content/plugins`
    And I run `if test -d wp-content/plugins; then echo "fail"; fi`
    Then STDOUT should be empty

    When I run `wp plugin install akismet --activate`
    Then STDOUT should not be empty

    When I run `wp plugin list --status=active --fields=name,status`
    Then STDOUT should be a table containing rows:
      | name       | status   |
      | akismet    | active   |

  Scenario: Plugin name with HTML entities
    Given a WP install

    When I run `wp plugin install debug-bar-list-dependencies`
    Then STDOUT should contain:
      """
      Installing Debug Bar List Script & Style Dependencies
      """

  Scenario: Enable and disable all plugins
    Given a WP install

    When I run `wp plugin activate --all`
    Then STDOUT should be:
      """
      Success: Plugin 'akismet' activated.
      Success: Plugin 'hello' activated.
      """

    When I run `wp plugin activate --all`
    Then STDOUT should be:
      """
      Success: All plugins are already activated.
      """

    When I run `wp plugin list --field=status`
    Then STDOUT should be:
      """
      active
      active
      must-use
      """

    When I run `wp plugin deactivate --all`
    Then STDOUT should be:
      """
      Success: Plugin 'akismet' deactivated.
      Success: Plugin 'hello' deactivated.
      """

    When I run `wp plugin deactivate --all`
    Then STDOUT should be:
      """
      Success: All plugins are already deactivated.
      """

    When I run `wp plugin list --field=status`
    Then STDOUT should be:
      """
      inactive
      inactive
      must-use
      """

  Scenario: Deactivate and uninstall a plugin, part one
    Given a WP install
    And these installed and active plugins:
      """
      akismet
      """

    When I run `wp plugin deactivate akismet --uninstall`
    Then STDOUT should contain:
      """
      Success: Plugin 'akismet' deactivated.
      Uninstalling 'akismet'...
      Success: Uninstalled and deleted 'akismet' plugin.
      """

    When I try `wp plugin get akismet`
    Then STDERR should be:
      """
      Error: The 'akismet' plugin could not be found.
      """

  Scenario: Deactivate and uninstall a plugin, part two
    Given a WP install
    And these installed and active plugins:
      """
      akismet
      """

    When I run `wp plugin uninstall akismet --deactivate`
    Then STDOUT should contain:
      """
      Deactivating 'akismet'...
      Success: Plugin 'akismet' deactivated.
      Success: Uninstalled and deleted 'akismet' plugin.
      """

    When I try `wp plugin get akismet`
    Then STDERR should be:
      """
      Error: The 'akismet' plugin could not be found.
      """


  Scenario: Uninstall a plugin without deleting
    Given a WP install

    When I run `wp plugin install akismet --version=2.5.7 --force`
    Then STDOUT should not be empty

    When I run `wp plugin uninstall akismet --skip-delete`
    Then STDOUT should contain:
      """
      Success: Ran uninstall procedure for
      """

  Scenario: Two plugins, one directory
    Given a WP install
    And a wp-content/plugins/handbook/handbook.php file:
      """
      <?php
      /**
       * Plugin Name: Handbook
       * Description: Features for a handbook, complete with glossary and table of contents
       * Author: Nacin
       */
      """
    And a wp-content/plugins/handbook/functionality-for-pages.php file:
      """
      <?php
	  /**
	   * Plugin Name: Handbook Functionality for Pages
       * Description: Adds handbook-like table of contents to all Pages for a site. Covers Table of Contents and the "watch this page" widget
       * Author: Nacin
       */
      """

    When I run `wp plugin list --fields=name,status`
    Then STDOUT should be a table containing rows:
      | name                             | status   |
      | handbook/handbook                | inactive |
      | handbook/functionality-for-pages | inactive |

    When I run `wp plugin activate handbook/functionality-for-pages`
    Then STDOUT should not be empty

    When I run `wp plugin list --fields=name,status`
    Then STDOUT should be a table containing rows:
      | name                             | status   |
      | handbook/handbook                | inactive |
      | handbook/functionality-for-pages | active   |

  Scenario: Install a plugin, then update to a specific version of that plugin
    Given a WP install

    When I run `wp plugin install akismet --version=2.5.7 --force`
    Then STDOUT should not be empty

    When I run `wp plugin update akismet --version=2.6.0`
    Then STDOUT should not be empty

    When I run `wp plugin list --fields=name,version`
    Then STDOUT should be a table containing rows:
      | name       | version   |
      | akismet    | 2.6.0     |

  Scenario: Ignore empty slugs
    Given a WP install

    When I run `wp plugin install ''`
    Then STDERR should contain:
      """
      Warning: Ignoring ambigious empty slug value.
      """
    And STDOUT should not contain:
      """
      Plugin installed successfully
      """
