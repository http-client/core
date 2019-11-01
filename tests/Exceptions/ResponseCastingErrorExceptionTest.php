<?php

declare(strict_types=1);

namespace WeForge\Tests\Exceptions;

use Mockery;
use Psr\Http\Message\ResponseInterface;
use WeForge\Exceptions\ResponseCastingErrorException;
use WeForge\Tests\TestCase;

class ResponseCastingErrorExceptionTest extends TestCase
{
    public function testGetNullResponse()
    {
        $e = new ResponseCastingErrorException;
        $this->assertNull($e->getResponse());
    }

    public function testGetResponse()
    {
        $e = new ResponseCastingErrorException;
        $e->withResponse(Mockery::mock(ResponseInterface::class));
        $this->assertInstanceOf(ResponseInterface::class, $e->getResponse());
    }
}
