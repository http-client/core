<?php

namespace WeForge\Http;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use WeForge\Concerns\ResponseCastable;

class Client
{
    use ResponseCastable;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $options;

    /**
     * Client Constructor.
     */
    public function __construct()
    {
        $this->options = func_get_args();
    }

    /**
     * Makes a get request.
     *
     * @param string $uri
     * @param array  $query
     *
     * @return mixed
     */
    public function get($uri, $query = [])
    {
        return $this->castsResponse(
            $this->getHttpClient()->request('GET', $uri, ['query' => $query])
        );
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient ?: $this->httpClient = new GuzzleHttp([
            'base_uri' => $this->baseUri,
            'handler' => $this->getHandlerStack(),
        ]);
    }

    /**
     * @return \GuzzleHttp\HandlerStack
     */
    protected function getHandlerStack(): HandlerStack
    {
        $stack = HandlerStack::create();

        $this->apply($stack);

        return $stack;
    }

    /**
     * Apply to handler stack.
     *
     * @param \GuzzleHttp\HandlerStack $handlerStack
     *
     * @return void
     */
    protected function apply(HandlerStack $handlerStack)
    {
        //
    }

    /**
     * @param string $uri
     *
     * @return $this
     */
    public function setBaseUri($uri)
    {
        $this->baseUri = $uri;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
