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

$container = new tad_DI52_Container();

$container['root-file'] = __FILE__;
$container['root-dir'] = dirname(__FILE__);

$container->register('qa_ServiceProviders_RenderEngine');
$container->register('qa_ServiceProviders_Adapters');
$container->register('qa_ServiceProviders_Configurations');
$container->register('qa_ServiceProviders_Options');

