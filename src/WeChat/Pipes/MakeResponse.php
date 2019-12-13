<?php

declare(strict_types=1);

namespace WeForge\WeChat\Pipes;

use Symfony\Component\HttpFoundation\Response;
use WeForge\Concerns\GeneratesRandomString;
use WeForge\WeChat\Decorators\FinallyResult;
use WeForge\WeChat\Encryption\Encrypter;

class MakeResponse
{
    use GeneratesRandomString;

    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string|null
     */
    protected $aesKey;

    /**
     * @var bool
     */
    protected $needsEncrypt;

    public function __construct(string $appId, string $aesKey = null, bool $needsEncrypt = true)
    {
        $this->appId = $appId;
        $this->aesKey = $aesKey;
        $this->needsEncrypt = $needsEncrypt;
    }

    /**
     * Generates response.
     *
     * @param mixed $message
     */
    public function __invoke($message): Response
    {
        if ($message instanceof FinallyResult) {
            return new Response($message->content);
        }

        if (is_array($message)) {
            $xml = XMLBuilder::build($message);

            if ($this->needsEncrypt) {
                $encrypt = (new Encrypter($this->appId, $this->aesKey))->encrypt($xml);

                return XMLBuilder::build([
                    'Encrypt' => $encrypt,
                    'TimeStamp' => $timestamp = time(),
                    'Nonce' => $nonce = $this->generateRandomString(),
                    'MsgSignature' => $this->signature($encrypt, $timestamp, $nonce),
                ]);
            }

            return $xml;
        }

        if ($message instanceof Response) {
            return $message;
        }

        return new Response('success');
    }
}
