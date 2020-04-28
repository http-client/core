<?php

namespace HttpClient;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware as GuzzleMiddleware;
use HttpClient\Testing\FakesRequests;

class Client
{
    use FakesRequests;

    /**
     * @var \HttpClient\Middleware
     */
    // public $middleware;

    public $handlerStack;

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
        $this->handlerStack = HandlerStack::create();
        // $this->middleware = new Middleware;
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
        if ($this->httpClient) {
            return $this->httpClient;
        }

        foreach ($this->resolvedCallbacks as $callback) {
            call_user_func($callback, $this);
        }

        return $this->httpClient = new GuzzleHttp([
            'http_errors' => false,
            'base_uri' => $this->baseUri,
            'handler' => $this->buildHandlerStack(),
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
    protected function buildHandlerStack()
    {
        $this->handlerStack->push($this->buildRecorderHandler());
        $this->handlerStack->push($this->buildFakerHandler());
        $this->handlerStack->push(GuzzleMiddleware::mapResponse(function ($response) {
            if ($response->getStatusCode() >= 400) {
                throw new RequestException((new Response($response))->setTransferStats($this->transferStats));
            }

            return $response;
        }));

        return $this->handlerStack;
    }
}
