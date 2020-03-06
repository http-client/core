<?php

declare(strict_types=1);

namespace HttpClient;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use HttpClient\Concerns\InteractsWithExceptionHandling;
use HttpClient\Concerns\ResponseCastable;
use HttpClient\Testing\FakesRequests;
use HttpClient\Testing\RecordsRequests;

class Client
{
    use ResponseCastable, InteractsWithExceptionHandling,
        FakesRequests, RecordsRequests;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * The GuzzleHttp client instance.
     *
     * @var \Psr\Http\Client\ClientInterface
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
     * Make an http request.
     *
     * @ignore
     *
     * @return mixed
     */
    public function send(string $method, string $uri = '', array $options = [])
    {
        return $this->withExceptionHandling(function () use ($method, $uri, $options) {
            return $this->castResponse($this->getHttpClient()->request($method, $uri, $options));
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

    protected function getHandlerStack(): HandlerStack
    {
        $stack = HandlerStack::create();

        $stack->push($this->recorderHandler());
        $stack->push($this->fakerHandler());

        return $stack;
    }

    public static function unfake()
    {
        static::$fakers = [];
        static::$records = [];
    }
}
