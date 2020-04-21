<?php

declare(strict_types=1);

namespace HttpClient;

use HttpClient\Plugin\PluginManager;
use League\Container\Container;
use League\Event\Emitter;

class Application
{
    protected $container;

    protected $providers = [];

    /**
     * The client instances.
     *
     * @var array
     */
    protected $clients = [
        //
    ];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * Create a new http-client instance.
     */
    public function __construct(array $config = [])
    {
        $this->container = new Container;
        $this->container->share('config', $config);
        $this->container->share(static::class, $this);
        $this->container->share('events', new Emitter);
        $this->container->share('plugins', new PluginManager);

        foreach ($this->clients as $key => $client) {
            $this->container->share($key, $client)->addArgument(static::class);
        }

        if (isset($this->config['http']['base_uri'])) {
            $this->on(Events\ClientResolved::class, function ($event) {
                $event->client->setBaseUri($this->config['http']['base_uri']);
            });
        }

        $this->boot();
        $this->registerServiceProviders();

        foreach ($this->listen as $event => $listener) {
            $this->on($event, function ($event) use ($listener) {
                call_user_func(new $listener($this), $event);
            });
        }

        foreach ($this->plugins->provides() as $name => $provide) {
            $this->container->share($name, $provide)->addArgument(static::class);
        }
        $this->bootExtensions();
    }

    public function on($event, $listener)
    {
        $this->events->addListener($event, $listener);
    }

    public function addServiceProvider($provider)
    {
        $this->container->addServiceProvider($provider);
    }

    protected function registerServiceProviders()
    {
        foreach ($this->providers as $provider) {
            $this->addServiceProvider($provider);
        }
    }

    protected function bootExtensions()
    {
        foreach ($this->plugins->extensions() as $extension) {
            call_user_func(new $extension, $this);
        }
    }

    /**
     * @return void
     */
    protected function boot()
    {
        //
    }

    public function __get($key)
    {
        return $this->container->get($key);
    }
}
