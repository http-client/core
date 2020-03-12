<?php

declare(strict_types=1);

namespace HttpClient\Core;

use Pimple\Container;

class Application extends Container
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * Create a new http-client instance.
     */
    public function __construct(array $options = [])
    {
        parent::__construct();

        $this['options'] = function () use ($options) {
            return $options;
        };

        if (isset($this['options']['http']['base_uri'])) {
            $this->setBaseUri($this['options']['http']['base_uri']);
        }

        $this->boot();
    }

    /**
     * @param string $uri
     *
     * @ignore
     *
     * @return $this
     */
    public function setBaseUri($uri)
    {
        $this->baseUri = $uri;

        return $this;
    }

    /**
     * @ignore
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @return void
     */
    protected function boot()
    {
        //
    }

    protected function prependBaseUri($value)
    {
        $parsed = parse_url($this->getBaseUri());

        return sprintf('%s://%s', $parsed['scheme'], $value.'.'.$parsed['host']);
    }

    public function __get($name)
    {
        return $this[$name];
    }
}
