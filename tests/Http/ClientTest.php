<?php

declare(strict_types=1);

namespace WeForge\Tests\Http;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Process\Process;
use WeForge\Concerns\CastsResponse;
use WeForge\Http\Client;
use WeForge\Tests\TestCase;

class ClientTest extends TestCase
{
    use CastsResponse;

    const SERVER_PORT = 18329;

    private static $process;

    public static function setUpBeforeClass(): void
    {
        static::$process = new Process('php -S localhost:'.static::SERVER_PORT.' -t '.__DIR__.'/runtime');
        static::$process->start();
        usleep(100000);
    }

    public static function tearDownAfterClass(): void
    {
        static::$process->stop();
    }

    public function testGet()
    {
        $this->assertInstanceOf(ResponseInterface::class, $response = $this->getClient()->get('get', ['name' => 'weforge', 'id' => 123, 'ok' => false]));

        $response = $this->castsResponseToArray($response);
        $this->assertSame($this->baseUri().'/get', $response['url']);
        $this->assertSame('GET', $response['method']);
        $this->assertSame(['name' => 'weforge', 'id' => '123', 'ok' => '0'], $response['query']);
        $this->assertSame([], $response['json']);
    }

    public function testPost()
    {
        $response = $this->getClient()->post('post', ['name' => 'weforge', 'id' => 123, 'ok' => false]);
        $this->assertInstanceOf(ResponseInterface::class, $response);

        $response = $this->castsResponseToArray($response);
        $this->assertSame($this->baseUri().'/post', $response['url']);
        $this->assertSame('POST', $response['method']);
        $this->assertSame(['name' => 'weforge', 'id' => 123, 'ok' => false], $response['json']);
    }

    public function getClient()
    {
        $client = new Client;
        $client->setBaseUri($this->baseUri());

        return $client;
    }

    protected function baseUri()
    {
        return 'http://localhost:'.static::SERVER_PORT;
    }
}
