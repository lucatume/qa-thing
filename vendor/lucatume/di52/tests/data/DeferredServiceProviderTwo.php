<?php

class DeferredServiceProviderTwo extends tad_DI52_ServiceProvider
{
    protected $deferred = true;

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->singleton('TestInterfaceOne', 'ClassOne');
    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }

    public function provides()
    {
        return array(
            'TestInterfaceOne',
        );
    }
}