<?php
/**
 * Installs WordPress for the purpose of the unit-tests
 *
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

$configuration = unserialize($argv[1]);

$multisite = !empty($argv[2]) ? $argv[2] : false;

// require_once 'vendor/autoload.php';
require_once $configuration['autoload'];

if (!empty($multisite)) {
    wpbrowser_include_patchwork();

    Patchwork\redefine('is_multisite', function () {
        global $_is_multisite;

        if (empty($_is_multisite)) {
            return Patchwork\relay();
        }

        return true;
    });
}

if (!empty($configuration['activePlugins'])) {
    $activePlugins = $configuration['activePlugins'];
} else {
    $activePlugins = [];
}

printf("\nConfiguration:\n\n%s\n\n", json_encode($configuration, JSON_PRETTY_PRINT));

foreach ($configuration['constants'] as $key => $value) {
    define($key, $value);
}

$table_prefix = WP_TESTS_TABLE_PREFIX;


define('WP_INSTALLING', true);
//require_once $config_file_path;
require_once dirname(__FILE__) . '/functions.php';

tests_reset__SERVER();

$PHP_SELF = $GLOBALS['PHP_SELF'] = $_SERVER['PHP_SELF'] = '/index.php';

require_once ABSPATH . '/wp-settings.php';

require_once ABSPATH . '/wp-admin/includes/upgrade.php';
require_once ABSPATH . '/wp-includes/wp-db.php';

// Override the PHPMailer
global $phpmailer;
require_once(dirname(__FILE__) . '/mock-mailer.php');
$phpmailer = new MockPHPMailer();

/*
 * default_storage_engine and storage_engine are the same option, but storage_engine
 * was deprecated in MySQL (and MariaDB) 5.5.3, and removed in 5.7.
 */
if (version_compare($wpdb->db_version(), '5.5.3', '>=')) {
    $wpdb->query('SET default_storage_engine = InnoDB');
} else {
    $wpdb->query('SET storage_engine = InnoDB');
}
$wpdb->select(DB_NAME, $wpdb->dbh);

/**
 * Before dropping the tables include the active plugins as those might define
 * additional tables that should be dropped.
 **/
foreach ($activePlugins as $activePlugin) {
    printf("Including plugin [%s] files\n", $activePlugin);
    include_once WP_PLUGIN_DIR . '/' . $activePlugin;
}

echo "\nThe following tables will be dropped: ", "\n\t- ", implode("\n\t- ", $wpdb->tables), "\n";

echo "\nInstalling WordPress...\n";

foreach ($wpdb->tables() as $table => $prefixed_table) {
    $wpdb->query("DROP TABLE IF EXISTS $prefixed_table");
}

foreach ($wpdb->tables('ms_global') as $table => $prefixed_table) {
    $wpdb->query("DROP TABLE IF EXISTS $prefixed_table");

    // We need to create references to ms global tables.
    if ($multisite) {
        $wpdb->$table = $prefixed_table;
    }
}

// Prefill a permalink structure so that WP doesn't try to determine one itself.
add_action('populate_options', '_set_default_permalink_structure_for_tests');

wp_install(WP_TESTS_TITLE, 'admin', WP_TESTS_EMAIL, true, null, 'password');

// Delete dummy permalink structure, as prefilled above.
if (!is_multisite()) {
    delete_option('permalink_structure');
}
remove_action('populate_options', '_set_default_permalink_structure_for_tests');

if ($multisite) {
    echo "Installing network..." . PHP_EOL;

    define('WP_INSTALLING_NETWORK', true);

    $title = WP_TESTS_TITLE . ' Network';
    $subdomain_install = false;

    install_network();
    populate_network(1, WP_TESTS_DOMAIN, WP_TESTS_EMAIL, $title, '/', $subdomain_install);
    $wp_rewrite->set_permalink_structure('');


    // activate monkey-patching on `is_multisite` using Patchwork, see above
    // this is to allow plugins that could check for `is_multisite` on activation to work as intended
    global $_is_multisite, $current_site;
    $_is_multisite = $multisite;

    // spoof the `$current_site` global
    if (empty($current_site)) {
        $current_site = new stdClass();
    }

    $current_site->id = 1;
    $current_site->blog_id = 1;
}

// finally activate the plugins that should be activated
if (!empty($activePlugins)) {
    $activePlugins = array_unique($activePlugins);

    if ($multisite) {
        require(ABSPATH . WPINC . '/class-wp-site-query.php');
        require(ABSPATH . WPINC . '/class-wp-network-query.php');
        require(ABSPATH . WPINC . '/ms-blogs.php');
        require(ABSPATH . WPINC . '/ms-settings.php');
    }

    foreach ($activePlugins as $plugin) {
        printf("\n%sctivating plugin [%s]...", $multisite ? 'Network a' : 'A', $plugin);
        activate_plugin($plugin, null, $multisite, false);
    }
}
