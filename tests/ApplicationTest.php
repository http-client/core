<?php

namespace HttpClient\Tests;

use HttpClient\Application;
use HttpClient\Client;
use HttpClient\Config\Repository;
use League\Container\Exception\NotFoundException;
use League\Event\Emitter;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testBaseDefinitions()
    {
        $app = new Application;

        $this->assertInstanceOf(Repository::class, $app->config);
        $this->assertSame([], $app->config->all());
        $this->assertInstanceOf(Application::class, $app->app);
        $this->assertInstanceOf(Emitter::class, $app->events);
        $this->assertInstanceOf(Client::class, $app->client);
    }

    public function testDefinitionNotFoundException()
    {
        $app = new Application;

        $this->expectException(NotFoundException::class);
        $app->doesnexists;
    }
}
