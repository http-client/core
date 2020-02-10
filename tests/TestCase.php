<?php

declare(strict_types=1);

namespace HttpClient\Tests;

use GuzzleHttp\ClientInterface;
use HttpClient\Client;
use Mockery;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function mockClient(Client $client)
    {
        $response = new TestResponse;

        return $client->setHttpClient(Mockery::mock(ClientInterface::class, function ($mock) use ($response) {
            $mock->shouldReceive('request')
                ->withArgs($response->setExpectedArguments())
                ->andReturn($response);
        }));
    }
}
