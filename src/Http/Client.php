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
    public function get(string $uri, array $query = [])
    {
        return $this->request('GET', $uri, ['query' => $query]);
    }

    /**
     * Makes a post request.
     *
     * @param string $uri
     *
     * @return mixed
     */
    public function post(string $uri)
    {
        return $this->request('POST', $uri);
    }

    /**
     * Makes an http request.
     *
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return mixed
     */
    public function request(string $method, string $uri = '', array $options = [])
    {
        return $this->castsResponse(
            $this->getHttpClient()->request($method, $uri, $options)
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
