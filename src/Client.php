<?php

declare(strict_types=1);

namespace WeClient;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LogLevel;
use WeClient\Concerns\ResponseCastable;
use WeForge\Support\Logger;

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
     * @return mixed
     */
    public function get(string $uri, array $query = [])
    {
        return $this->request('GET', $uri, ['query' => $query]);
    }

    /**
     * Makes a post request.
     *
     * @return mixed
     */
    public function post(string $uri, array $json = [])
    {
        return $this->request('POST', $uri, ['json' => $json]);
    }

    /**
     * Makes an http request.
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
        return $this->httpClient ?: $this->httpClient = new GuzzleHttp(array_merge([
            'base_uri' => $this->baseUri,
            'handler' => $this->getHandlerStack(),
        ], $this->config()));
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

    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    protected function getHandlerStack(): HandlerStack
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
        // $stack->push(
        //     Middleware::log(new Logger, new MessageFormatter(MessageFormatter::DEBUG), LogLevel::DEBUG)
        // );
    }

    /**
     * @return array
     */
    protected function config()
    {
        return [];
    }
}
