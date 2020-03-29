<?php

declare(strict_types=1);

namespace HttpClient\Core;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\HandlerStack;

class Client
{
    /**
     * The guzzle http instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * The application instance.
     *
     * @var \HttpClient\Core\Application
     */
    protected $app;

    /**
     * HttpClient constructor.
     *
     * @param \HttpClient\Core\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Make an http request.
     *
     * @return mixed
     */
    public function todotodo(string $method, string $uri = '', array $options = [])
    {
        return $this->castResponse(
            $this->getHttpClient()->request($method, $uri, $options)
        );
    }

    /**
     * @return callable
     */
    protected function castResponseUsing()
    {
        return function ($response) {
            return new Response($response);
        };
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     */
    protected function castResponse($response)
    {
        return call_user_func_array($this->castResponseUsing(), [$response]);
    }

    /**
     * Resolve a http client.
     *
     * @return \GuzzleHttp\ClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient ?: $this->httpClient = new GuzzleHttp([
            'http_errors' => false,
            'base_uri' => $this->app->getBaseUri(),
            'handler' => $this->getHandlerStack(),
        ]);
    }

    /**
     * @return \GuzzleHttp\HandlerStack
     */
    protected function getHandlerStack()
    {
        $stack = HandlerStack::create();

        $stack->push($this->buildRequestExceptionMiddleware());

        return $stack;
    }

    /**
     * @return callable
     */
    protected function buildRequestExceptionMiddleware()
    {
        return function ($handler) {
            return function ($request, $options) use ($handler) {
                return $handler($request, $options)->then(function ($response) use ($request) {
                    if ($response->getStatusCode() >= 400) {
                        throw new RequestException($request, new Response($response));
                    }

                    return $response;
                });
            };
        };
    }
}
