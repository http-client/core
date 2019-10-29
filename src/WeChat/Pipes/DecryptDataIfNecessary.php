<?php

declare(strict_types=1);

namespace WeForge\WeChat\Pipes;

use WeForge\WeChat\Encryption\Encrypter;

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
     *
     * @param string      $appId
     * @param string|null $aesKey
     */
    public function __construct(string $appId, string $aesKey = null)
    {
        $this->appId = $appId;
        $this->aesKey = $aesKey;
    }

    /**
     * Decrypt and replace to the original array if necessary.
     *
     * @param array $data
     *
     * @return array
     */
    public function __invoke(array $data): array
    {
        $encrypter = new Encrypter($this->appId, $this->aesKey);

        if (isset($data['Encrypt'])) {
            $encrypter->decrypt($data['Encrypt']);
        }

        return $data;
    }
}
