<?php

namespace WeForge\Tests\WeChat\MediaPlatform;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WeForge\Tests\TestCase;
use WeForge\WeChat\Exceptions\InvalidSignatureException;
use WeForge\WeChat\MediaPlatform\Server;

class ServerTest extends TestCase
{
    public function testResolveGetEchostr()
    {
        $request = Request::create('', 'GET', ['signature' => '76480565cbe296026c53aaacd1ad523a1ddba24f', 'echostr' => '5359042477875521533', 'timestamp' => '1409304348', 'nonce' => 'xxxxxx']);
        $response = $this->newServerWithRequest($request)->resolve();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('5359042477875521533', $response->getContent());
    }

    public function testInvalidSignature()
    {
        $server = $this->newServerWithRequest(Request::create('uri?signature=xxx&timestamp=xxx&nonce=xxx', 'POST', [], [], [], [], '<xml><invalid></invalid></xml>'));

        $this->expectException(InvalidSignatureException::class);
        $server->resolve();
    }

    protected function newServerWithRequest($request)
    {
        return new Server(['app_id' => 'wxb11529c136998cb6', 'token' => 'pamtest', 'aes_key' => 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG'], $request);
    }
}
