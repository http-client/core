<?php

declare(strict_types=1);

namespace HttpClient\Tests;

use GuzzleHttp\ClientInterface;
use HttpClient\Client;
use Mockery;
use PHPUnit\Framework\TestCase;

abstract class ClientTestCase extends TestCase
{
    protected $request;
    protected $options;

    protected function setUp(): void
    {
        parent::setUp();

        Client::fake(function ($request, $options) {
            $this->request = $request;
            $this->options = $options;

            return Client::response();
        });
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Client::unfake();
    }

    // protected function mockClientxxx(Client $client)
    // {
    //     $response = new TestResponse;

    //     return $client->setHttpClient(Mockery::mock(ClientInterface::class, function ($mock) use ($response) {
    //         $mock->shouldReceive('request')
    //             ->withArgs($response->setExpectedArguments())
    //             ->andReturn($response);
    //     }));
    // }
}
