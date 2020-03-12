<?php

declare(strict_types=1);

namespace HttpClient\Core;

use HttpClient\Concerns\ResolvesCache;
use HttpClient\Concerns\ResolvesLogger;
use HttpClient\Testing\FakesRequests;
use HttpClient\Testing\RecordsRequests;
use Symfony\Component\HttpClient\HttpClient;

class Client
{
    // use FakesRequests, RecordsRequests, ResolvesCache, ResolvesLogger;

    /**
     * The http client instance.
     *
     * @var \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var array
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
            $response = new Response($response);

            $response->throw();

            return $response;
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
     * @return \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient
            ?: $this->httpClient = HttpClient::create(['base_uri' => $this->app->getBaseUri()]);
    }
}
