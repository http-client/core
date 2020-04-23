<?php

namespace HttpClient;

use HttpClient\Config\Repository;
use HttpClient\Contracts\Application as ApplicationContract;
use HttpClient\Plugin\PluginManager;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Event\Emitter;

/**
 * @property-read HttpClient\Contracts\Application $app
 * @property-read \HttpClient\Config\Repository $config
 * @property-read \HttpClient\Client $client
 * @property-read \League\Event\Emitter $events
 * @property-read \HttpClient\Plugin\PluginManager $plugins
 */
class Application implements ApplicationContract
{
    /**
     * The container instance.
     *
     * @var \League\Container\Container
     */
    protected $container;

    /**
     * The definitions in the container.
     *
     * @var array
     */
    protected $definitions = [];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * Create a new Application instance.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->container = (new Container)
                                ->delegate((new ReflectionContainer)->cacheResolutions());

        $this->container->share(Repository::class, function () use ($config) {
            return new Repository($config);
        });

        $this->container->share(ApplicationContract::class, function () {
            return $this;
        });
        $this->container->share(Emitter::class);
        $this->container->share(PluginManager::class);
        $this->container->share(Client::class);

        if (isset($this->config['http']['base_uri'])) {
            $this->client->setBaseUri($this->config['http']['base_uri']);
        }

        foreach ($this->listen as $event => $listener) {
            $this->on($event, function ($event) use ($listener) {
                call_user_func(new $listener($this), $event);
            });
        }

        $this->boot();

        array_map('call_user_func', array_map([$this, '__get'], $this->plugins->extensions()));
    }

    /**
     * The definitions in the container.
     *
     * @return array
     */
    public function definitions()
    {
        return array_merge([
            'app' => ApplicationContract::class,
            'events' => Emitter::class,
            'plugins' => PluginManager::class,
            'config' => Repository::class,
            'client' => Client::class,
        ], $this->definitions);
    }

    /**
     * @param $event
     * @param $listener
     *
     * @return void
     */
    public function on($event, $listener)
    {
        $this->events->addListener($event, $listener);
    }

    /**
     * @return void
     */
    protected function boot()
    {
        //
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->definitions()[$key])) {
            $key = $this->definitions()[$key];
        }

        return $this->container->get($key);
    }
}
