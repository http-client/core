<?php

declare(strict_types=1);

namespace HttpClient\Tests;

use HttpClient\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ClientFakingTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Client;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Client::unfake();
    }

    public function testResponseIsReturnedAfterFaking()
    {
        Client::fake();

        $responseA = $this->client->send('GET', 'http://http-client.com/test');
        $responseB = $this->client->send('GET', 'http://http-client.com/test');

        $this->assertInstanceOf(ResponseInterface::class, $responseA);
        $this->assertSame(200, $responseA->getStatusCode());
        $this->assertSame('', (string) $responseA->getBody());
        $this->assertSame([], $responseA->getHeaders());
        $this->assertInstanceOf(ResponseInterface::class, $responseB);
        $this->assertSame(200, $responseB->getStatusCode());
        $this->assertSame('', (string) $responseB->getBody());
        $this->assertSame([], $responseB->getHeaders());
    }

    public function testFakesCustomResponse()
    {
        Client::fake(Client::response('fake', 201, ['X-Foo' => 'bar']));

        $response = $this->client->send('GET', 'http://http-client.com/test');

        $this->assertSame('fake', (string) $response->getBody());
        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame(['X-Foo' => ['bar']], $response->getHeaders());
    }

    public function testFakesCustomResponseUsingClosure()
    {
        Client::fake(function () {
            return Client::response('fake-again', 204, ['X-Foo' => 'baz']);
        });

        $response = $this->client->send('GET', 'http://http-client.com/test');

        $this->assertSame('fake-again', (string) $response->getBody());
        $this->assertSame(204, $response->getStatusCode());
        $this->assertSame(['X-Foo' => ['baz']], $response->getHeaders());
    }

    public function testRequestsAreSent()
    {
        Client::fake();

        $this->client->send('GET', 'http://http-client.com/test-a');
        $this->client->send('POST', 'http://http-client.com/test-b');

        Client::assertSent(0, function ($request) {
            return (string) $request->getUri() === 'http://http-client.com/test-a'
                    && $request->getMethod() === 'GET';
        });

        Client::assertSent(1, function ($request) {
            return (string) $request->getUri() === 'http://http-client.com/test-b'
                    && $request->getMethod() === 'POST';
        });
    }

    public function testFoo()
    {
        Client::fake([
            Client::response('request-a'),
            Client::response('request-b'),
        ]);

        $this->client->send('GET', 'http://http-client.com/test-a');
        $this->client->send('POST', 'http://http-client.com/test-b');

        Client::assertSent(0, function ($request, $response) {
            return (string) $request->getUri() === 'http://http-client.com/test-a'
                    && $request->getMethod() === 'GET'
                    && (string) $response->getBody() === 'request-a';
        });
        Client::assertSent(1, function ($request, $response) {
            return (string) $request->getUri() === 'http://http-client.com/test-b'
                    && $request->getMethod() === 'POST'
                    && (string) $response->getBody() === 'request-b';
        });
    }
}
