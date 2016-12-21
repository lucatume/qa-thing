<?php


class qa_ServiceProviders_RenderEngine extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container['templates'] = $this->container['root'] . '/templates';
		$this->container->singleton( 'qa_Interfaces_RenderEngine', array( $this, 'make_render_engine' ) );
	}

	/**
	 * Binds and sets up implementations at boot time.
	 */
	public function boot() {
		// no-op
	}

	public function make_render_engine() {
		return new qa_Utils_RenderEngine( $this->container['templates'] );
	}
}