<?php

class qa_ServiceProviders_RenderEngine extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container->setVar('templates-dir', $this->container->getVar('root-dir') . '/templates');
		$this->container->setVar('templates-partials-dir',
			$this->container->getVar('root-dir') . '/templates/partials');
		$this->container->singleton('qa_RenderEngines_HandlebarsI', $this->container->callback($this, 'buildHandlebars'));
	}

	public function buildHandlebars() {
		$options = array('extension' => '.hbs');

		$engine = new Handlebars_Engine(array(
			'loader' => new Handlebars_Loader_FilesystemLoader($this->container->getVar('templates-dir'), $options),
			'partials_loader' => new Handlebars_Loader_FilesystemLoader($this->container->getVar('templates-partials-dir'), $options)
		));

		return $engine;
	}
}