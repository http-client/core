<?php

declare(strict_types=1);

namespace HttpClient;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

class Client
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * The guzzle http instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    protected $transferStats;

    protected $castResponseUsing;

    /**
     * The application instance.
     *
     * @var \HttpClient\Core\Application
     */
    protected $app;

    protected $middleware = [];

    /**
     * HttpClient constructor.
     *
     * @param \HttpClient\Core\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->push($this->buildRequestExceptionMiddleware(), 'request.exception');

        $this->app->events->emit(new Events\ClientResolved($this));
    }

    public function setBaseUri($uri)
    {
        $this->baseUri = $uri;

        return $this;
    }

    /**
     * Make an http request.
     *
     * @return mixed
     */
    public function makeRequest(string $method, string $uri = '', array $options = [])
    {
        $response = $this->getHttpClient()->request($method, $uri, $options);

        return $this->castResponse($response);
    }

    /**
     * @return $this
     */
    public function castResponseUsing(callable $callback)
    {
        $this->castResponseUsing = $callback;

        return $this;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     */
    protected function castResponse($response)
    {
        return call_user_func($this->castResponseUsing ?: function ($response) {
            return (new Response($response))
                        ->setTransferStats($this->transferStats);
        }, $response);
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
            'base_uri' => $this->baseUri,
            'handler' => $this->getHandlerStack(),
            'on_stats' => function ($stats) {
                $this->transferStats = $stats;
            },
        ]);
    }

    public function push($middleware, $name = null)
    {
        $this->middleware[$name ?: spl_object_hash($middleware)] = $middleware;

        return $this;
    }

    /**
     * @return \GuzzleHttp\HandlerStack
     */
    protected function getHandlerStack()
    {
        $stack = HandlerStack::create();
        // dd($this->middleware);
        foreach ($this->middleware as $name => $middleware) {
            $stack->push($middleware, $name);
        }

        return $stack;
    }

    /**
     * @return callable
     */
    protected function buildRequestExceptionMiddleware()
    {
        return Middleware::mapResponse(function ($response) {
            if ($response->getStatusCode() >= 400) {
                throw new RequestException((new Response($response))->setTransferStats($this->transferStats));
                // throw new RequestException(
                //     new Response($response), $this->transferStats
                // );
            }

            return $response;
        });
        // return function ($handler) {
        //     return function ($request, $options) use ($handler) {
        //         return $handler($request, $options)->then(function ($response) use ($request) {
        //             if ($response->getStatusCode() >= 400) {
        //                 throw new RequestException($request, new Response($response));
        //             }

        //             return $response;
        //         });
        //     };
        // };
    }

    protected function build()
    {
        //
    }
}
