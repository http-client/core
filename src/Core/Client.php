<?php

declare(strict_types=1);

namespace HttpClient\Core;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\HandlerStack;
use HttpClient\Concerns\ResolvesCache;
use HttpClient\Concerns\ResolvesLogger;
use HttpClient\Testing\FakesRequests;
use HttpClient\Testing\RecordsRequests;
use Symfony\Component\HttpClient\HttpClient;

class Client
{
    // use FakesRequests, RecordsRequests, ResolvesCache, ResolvesLogger;
    /**
     * The GuzzleHttp client instance.
     *
     * @var \Psr\Http\Client\ClientInterface
     */
    protected $httpClient;

    /**
     * The transfer stats for the request.
     *
     * \GuzzleHttp\TransferStats
     */
    protected $transferStats;

    /**
     * @var array
     */
    protected $app;

    /**
     * HttpClient constructor.
     */
    public function __construct($app)
    {
        $this->app = $app;
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
        // var_dump($options);die;
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
    public function castResponse($response)
    {
        // return $response;
        return call_user_func_array($this->castResponseUsing(), [$response]);
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getHttpClient()
    {
        return HttpClient::createForBaseUri($this->app->getBaseUri());
        // return $this->httpClient ?: $this->httpClient = new GuzzleHttp([
        //     'http_errors' => false,
        //     'base_uri' => $this->baseUri,
        //     'handler' => $this->getHandlerStack(),
        //     'on_stats' => function ($stats) {
        //         $this->transferStats = $stats;
        //     },
        // ]);
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

        $stack->push($this->loggerHandler());
        $stack->push($this->recorderHandler());
        $stack->push($this->fakerHandler());

        $this->apply($stack);

        return $stack;
    }

    /**
     * Apply to handler stack
     *
     * @param \GuzzleHttp\HandlerStack $stack
     *
     * @return void
     */
    protected function apply($stack)
    {
        //
    }

    public static function unfake()
    {
        static::$fakers = [];
        static::$records = [];
    }
}
