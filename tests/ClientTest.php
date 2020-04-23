<?php

namespace HttpClient\Tests;

use HttpClient\Client;
use HttpClient\Factory;
use HttpClient\RequestException;
use HttpClient\Response;
use HttpClient\Testing\Recorder;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testSetBaseUri()
    {
        $client = new Client;

        $this->assertNull($client->getBaseUri());

        $client->setBaseUri('https://http-client.com');

        $this->assertSame('https://http-client.com', $client->getBaseUri());
    }

    public function testRequest()
    {
        $client = new Client;

        $client->fake(function () {
            return ['hello' => 'world'];
        });

        $response = $client->request('GET', '/foo');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('{"hello":"world"}', $response->body());
    }

    public function testCastResponseUsing()
    {
        $client = new Client;

        $client->fake(function () {
            return ['hello' => 'world'];
        });
        $client->castResponseUsing(function ($response) {
            $this->assertInstanceOf(\GuzzleHttp\Psr7\Response::class, $response);

            return 'custom-response';
        });

        $response = $client->request('GET', '/foo');
        $this->assertSame('custom-response', $response);
    }

    // public function testThrowOnClientErrors()
    // {
    //     $client = new Client;
    //     $client->fake(Factory::response(['hello' => 'world'], 401));

    //     $this->expectException(RequestException::class);
    //     $response = $client->request('GET', '/foo');
    // }

    // public function testDisableThrowOnClientErrors()
    // {
    //     $client = new Client;
    //     $client->withoutExceptionHandling();
    //     $client->fake(Factory::response(['hello' => 'world'], 401));

    //     $response = $client->request('GET', '/foo');

    //     $this->assertInstanceOf(\HttpClient\Response::class, $response);
    // }

    public function testFake()
    {
        $client = new Client;
        $fake = $client->fake();

        $client->request('GET', '/foo');

        $this->assertInstanceOf(Recorder::class, $fake);
        $fake->assertSentCount(1);
        $fake->assertSent(function ($request) {
            return $request->getUri()->getPath() === '/foo'
                && $request->getMethod() === 'GET';
        });
    }
}
