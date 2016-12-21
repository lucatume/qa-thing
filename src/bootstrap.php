<?php
$container = new tad_DI52_Container();

$container['root'] = dirname( dirname( __FILE__ ) );
$container['root-file'] = dirname( dirname( __FILE__ ) ) . '/app-thing.php';

$container->register( 'qa_ServiceProviders_Utils' );
$container->register( 'qa_ServiceProviders_Repositories' );
$container->register( 'qa_ServiceProviders_Endpoints' );
$container->register( 'qa_ServiceProviders_RenderEngine' );
$container->register( 'qa_ServiceProviders_Scripts' );
$container->register( 'qa_ServiceProviders_Options' );

return $container;
