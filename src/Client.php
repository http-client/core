<?php

declare(strict_types=1);

namespace HttpClient;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use HttpClient\Concerns\InteractsWithExceptionHandling;
use HttpClient\Concerns\ResponseCastable;

class Client
{
    use ResponseCastable, InteractsWithExceptionHandling;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * The GuzzleHttp client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $options;

    /**
     * HttpClient constructor.
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Makes an http request.
     *
     * @ignore
     *
     * @return mixed
     */
    public function request(string $method, string $uri = '', array $options = [])
    {
        return $this->withExceptionHandling(function () use ($method, $uri, $options) {
            return $this->castsResponse($this->getHttpClient()->request($method, $uri, $options));
        });
    }

    /**
     * @ignore
     *
     * @return $this
     */
    public function setHttpClient(ClientInterface $client)
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * @ignore
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient ?: $this->httpClient = new GuzzleHttp(array_merge([
            'base_uri' => $this->baseUri,
            'handler' => $this->getHandlerStack(),
        ], []));
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
     * @ignore
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @ignore
     */
    public function getHandlerStack(): HandlerStack
    {
        $stack = HandlerStack::create();

        $this->apply($stack);

        return $stack;
    }

    /**
     * Apply to handler stack.
     *
     * @return void
     */
    protected function apply(HandlerStack $stack)
    {
        //
    }
}
