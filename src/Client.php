<?php

namespace HttpClient;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware as GuzzleMiddleware;

class Client
{
    /**
     * @var \HttpClient\Middleware
     */
    public $middleware;

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

    /**
     * The array of resolved callbacks.
     *
     * @var array
     */
    protected $resolvedCallbacks = [];

    /**
     * The transferStats instance.
     *
     * @var \GuzzleHttp\TransferStats
     */
    protected $transferStats;

    /**
     * The response caster.
     *
     * @var callable
     */
    protected $castResponseUsing;

    /**
     * @var bool
     */
    protected $withExceptionHandling = true;

    /**
     * Create a new HttpClient instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware = new Middleware;
    }

    /**
     * The base uri.
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * Set the base uri.
     *
     * @param string $uri
     *
     * @return $this
     */
    public function setBaseUri($uri)
    {
        $this->baseUri = $uri;

        return $this;
    }

    public function fake($response = null)
    {
        $recorder = new Testing\Recorder;

        $this->middleware->add('fake.recorder', $recorder->handler());
        $this->middleware->add('fake.response', function () use ($response) {
            return function () use ($response) {
                if (is_callable($response)) {
                    return Testing\Response::create($response->__invoke());
                }

                if ($response instanceof \GuzzleHttp\Promise\PromiseInterface) {
                    return $response;
                }

                return Testing\Response::create();
            };
        });

        return $recorder;
    }

    /**
     * Make an http request.
     *
     * @return mixed
     */
    public function request(string $method, string $uri = '', array $options = [])
    {
        return $this->castResponse(
            $this->getHttpClient()->request($method, $uri, $options)
        );
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
     * @return $this
     */
    public function withoutExceptionHandling()
    {
        $this->withExceptionHandling = false;

        return $this;
    }

    /**
     * Resolve a http client.
     *
     * @return \GuzzleHttp\ClientInterface
     */
    public function getHttpClient()
    {
        foreach ($this->resolvedCallbacks as $callback) {
            call_user_func($callback, $this);
        }

        return $this->httpClient ?: $this->httpClient = new GuzzleHttp([
            'http_errors' => false,
            'base_uri' => $this->baseUri,
            'handler' => $this->getHandlerStack(),
            'on_stats' => function ($stats) {
                $this->transferStats = $stats;
            },
        ]);
    }

    /**
     * Register a resolved callback with the application.
     *
     * @return $this
     */
    public function resolved(callable $callback)
    {
        $this->resolvedCallbacks[] = $callback;

        return $this;
    }

    /**
     * @return \GuzzleHttp\HandlerStack
     */
    protected function getHandlerStack()
    {
        $stack = HandlerStack::create();

        if ($this->withExceptionHandling) {
            $stack->push(GuzzleMiddleware::mapResponse(function ($response) {
                if ($response->getStatusCode() >= 400) {
                    throw new RequestException((new Response($response))->setTransferStats($this->transferStats));
                }

                return $response;
            }));
        }

        foreach ($this->middleware->all() as $name => $middleware) {
            $stack->push($middleware, $name);
        }

        return $stack;
    }
}
