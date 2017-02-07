<?php

class qa_Plugin {
	/**
	 * @var tad_DI52_ContainerInterface
	 */
	protected static $container;

	/**
	 * @return tad_DI52_ContainerInterface
	 */
	public static function getContainer() {
		return self::$container;
	}

	public static function init() {
		$container = new tad_DI52_Container();

		$root = dirname(dirname(dirname(__FILE__)));
		$container['root-file'] = $root . '/qa-thing.php';
		$container['root-dir'] = $root;

		$container->register('qa_ServiceProviders_Adapters');
		$container->register('qa_ServiceProviders_RenderEngine');
		$container->register('qa_ServiceProviders_Configurations');
		$container->register('qa_ServiceProviders_Options');

		self::$container = $container;
	}
}