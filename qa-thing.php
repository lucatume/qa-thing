<?php
/**
 * Plugin Name: QA Thing
 * Plugin URI: http://theAverageDev.com
 * Description: WordPress QA for the world.
 * Version: 1.0
 * Author: theAverageDev
 * Author URI: http://theAverageDev.com
 * License: GPL 2.0
 */

include dirname( __FILE__ ) . '/vendor/autoload_52.php';

$container = include dirname( __FILE__ ) . '/src/bootstrap.php';

add_action( 'plugins_loaded', array( $container, 'boot' ), 1 );
