<?php

declare(strict_types=1);

namespace WeForge\WeChat\Encryption;

use WeForge\Concerns\GeneratesRandomString;

class Encrypter
{
    use GeneratesRandomString;

    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $aesKey;

    /**
     * @var \WeForge\WeChat\Encryption\PKCS7Encoder
     */
    protected $pkcs7Encoder;

    /**
     * Encrypter constructor.
     *
     * @param string $appId
     * @param null   $aesKey
     */
    public function __construct(string $appId, $aesKey = null)
    {
        $this->appId = $appId;
        $this->aesKey = base64_decode($aesKey.'=');
        $this->pkcs7Encoder = new PKCS7Encoder;
    }

    /**
     * @param string $content
     *
     * @return string
     *
     * @throws \WeForge\WeChat\Encryption\EncryptException
     */
    public function encrypt($content)
    {
        $content = $this->pkcs7Encoder->encode(
            $this->generateRandomString().pack('N', strlen($content)).$content.$this->appId
        );

        $value = openssl_encrypt(
            $content, $this->getCipherMethod(), $this->aesKey, OPENSSL_NO_PADDING, $this->getInitializationVector()
        );

        if ($value === false) {
            throw new EncryptException('Could not encrypt the data.');
        }

        return base64_encode($value);
    }

    /**
     * @param string $content
     *
     * @return string
     *
     * @throws \WeForge\WeChat\Encryption\DecryptException|\WeForge\WeChat\Encryption\AppIdMismatchException
     */
    public function decrypt($content)
    {
        $decrypted = openssl_decrypt(
            base64_decode($content), $this->getCipherMethod(), $this->aesKey, OPENSSL_NO_PADDING, $this->getInitializationVector()
        );

        if ($decrypted === false) {
            throw new DecryptException('Could not decrypt the data.');
        }

        $result = $this->pkcs7Encoder->decode($decrypted);

        $content = substr($result, 16, strlen($result));
        $contentLen = unpack('N', substr($content, 0, 4))[1];

        if (substr($content, $contentLen + 4) !== $this->appId) {
            throw new AppIdMismatchException;
        }

        return substr($content, 4, $contentLen);
    }

    /**
     * Guesses cipher method by the given aes-key.
     *
     * @return string
     */
    protected function getCipherMethod()
    {
        return 'AES-'.(8 * strlen($this->aesKey)).'-CBC';
    }

    /**
     * @return false|string
     */
    protected function getInitializationVector()
    {
        return substr($this->aesKey, 0, 16);
    }
}
