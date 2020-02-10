<?php

declare(strict_types=1);

namespace HttpClient\WeChat\Pipes;

use HttpClient\WeChat\Encryption\Encrypter;

class DecryptDataIfNecessary
{
    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $aesKey;

    /**
     * DecryptDataIfNecessary constructor.
     */
    public function __construct(string $appId, string $aesKey = null)
    {
        $this->appId = $appId;
        $this->aesKey = $aesKey;
    }

    /**
     * Decrypt and replace to the original array if necessary.
     */
    public function __invoke(array $data): array
    {
        if (isset($data['Encrypt'])) {
            return call_user_func(
                new ContentInterpretation, (new Encrypter($this->appId, $this->aesKey))->decrypt($data['Encrypt'])
            );
        }

        return $data;
    }
}
