<?php

declare(strict_types=1);

namespace WeForge\Tests\WeChat\Pipes;

use WeForge\Tests\TestCase;
use WeForge\WeChat\Pipes\ValidateSignature;

class ValidateSignatureTest extends TestCase
{
    public function testEchostr()
    {
        $result = call_user_func(new ValidateSignature('jcVVVIy7i7j9i3MCOVORojzbbj13LvvL', [
            'signature' => '095de4d5eeae9eee10474982b0f0cc6ea92cc835', 'timestamp' => '1572355201', 'nonce' => '116851249',
        ]), []);
        $this->assertSame([], $result);
    }

    public function testPlainMode()
    {
        $content = [
            'ToUserName' => 'gh_259cc5ea017f',
            'FromUserName' => 'oyZPat6swTGdgiXQktgv83eBjFd0',
            'CreateTime' => '1572354351',
            'MsgType' => 'text',
            'Content' => 'WeForge',
            'MsgId' => '22510704161757249',
        ];
        $result = call_user_func(new ValidateSignature('jcVVVIy7i7j9i3MCOVORojzbbj13LvvL', ['signature' => '0ac01bb98149539001a8609f2d258c52885e4e8b', 'timestamp' => '1572354351', 'nonce' => '1818574184']), $content);
        $this->assertSame($result, $content);
    }

    public function testEncryptedMode()
    {
        $content = [
            'ToUserName' => 'gh_86f5bc7cc17d',
            'Encrypt' => 'is0XDf7r5IORjK4vcMcsVbOAsMHrwcO/OCXRjsF32VefefVLZkuxMgly++6CMED3rU5dUPpjP91EsRfNLTUN53lMNOu1rYWdLCOHr60CVoT4o0jQsQEhfERwbXDbSQhpgIxm2KGEWFyhlSQ5luoTTnmEcg+BedA8CmJ3KH33JW8lLxMd8vkpGoFMZHBUX11rzizzezr2raUk3f5UGMJTPmekqHO7Bf97FFV+rEm5/AhDrMyhwAH+5+L8EjP93c5V8tFN8Dxdegqw0aIuPU+qv6FlVnVLfPwOpuuygMx998yeFPSo9ZmHpY0vAB5WmB3p4jd3NKSNiwkyzxXoRpQDd9gaCpotADXWeGW8OZ4PG0WbkxaQM13CQnVrWLMDYWh9cyfxBo0PQqDqOV1KLW22a2YVVTIWendfmRC2vB75yQE=',
        ];
        $result = call_user_func(new ValidateSignature('jcVVVIy7i7j9i3MCOVORojzbbj13LvvL', ['signature' => '207c3107398c0476fb12f4bf5b912d1f9528d7b0', 'timestamp' => '1572357850',  'nonce' => '55936119', 'encrypt_type' => 'aes', 'msg_signature' => 'aa0c76fa50d2bda8ea64eef37e04d4f672e51e72']), $content);
        $this->assertSame($result, $content);
    }
}
