<?php

declare(strict_types=1);

namespace WeForge\Tests\WeChat\Encryption;

use WeForge\Tests\TestCase;
use WeForge\WeChat\Encryption\Encrypter;

class EncrypterTest extends TestCase
{
    public function testEncrypt()
    {
        $xml = '<xml><ToUserName><![CDATA[oia2Tj我是中文jewbmiOUlr6X-1crbLOvLw]]></ToUserName><FromUserName><![CDATA[gh_7f083739789a]]></FromUserName><CreateTime>1407743423</CreateTime><MsgType><![CDATA[video]]></MsgType><Video><MediaId><![CDATA[eYJ1MbwPRJtOvIEabaxHs7TX2D-HV71s79GUxqdUkjm6Gs2Ed1KF3ulAOA9H1xG0]]></MediaId><Title><![CDATA[testCallBackReplyVideo]]></Title><Description><![CDATA[testCallBackReplyVideo]]></Description></Video></xml>';
        $result = $this->getEncrypter()->encrypt($xml);

        $this->assertSame($xml, $this->getEncrypter()->decrypt($result));
    }

    protected function getEncrypter()
    {
        return new Encrypter('wxb11529c136998cb6', 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG');
    }
}
