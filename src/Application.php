<?php



namespace HttpClient;

use HttpClient\Config\Repository;
use HttpClient\Plugin\PluginManager;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Event\Emitter;

class Application
{
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
     * Create a new http-client instance.
     */
    public function __construct(array $config = [])
    {
        $this->container = (new Container)
                                ->delegate((new ReflectionContainer)->cacheResolutions());

        $this->container->share(Repository::class, function () use ($config) {
            return new Repository($config);
        });

        $this->container->share(static::class);
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

        // foreach ($this->plugins->provides() as $name => $provide) {
        //     $this->container->share($name, $provide)->addArgument(static::class);
        // }
        // $this->bootExtensions();
        $this->boot();
    }

    public function aliases()
    {
        return array_merge([
            'app' => static::class,
            'events' => Emitter::class,
            'plugins' => PluginManager::class,
            'config' => Repository::class,
            'client' => Client::class,
        ], $this->definitions);
    }

    public function on($event, $listener)
    {
        $this->events->addListener($event, $listener);
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
        if (isset($this->aliases()[$key])) {
            return $this->container->get($this->aliases()[$key]);
        }

        if (! $this->container->has($key)) {
            throw new DefinitionNotFoundException("Definition [{$key}] is not being managed by the container");
        }

        return $this->container->get($key);
    }
}
