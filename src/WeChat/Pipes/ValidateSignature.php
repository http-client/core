<?php

declare(strict_types=1);

namespace WeForge\WeChat\Pipes;

use WeForge\WeChat\Exceptions\InvalidSignatureException;

class ValidateSignature
{
    /**
     * @var string
     */
    protected $token;

    /**
     * The request query.
     *
     * @var array
     */
    protected $query;

    public function __construct(string $token, array $query = [])
    {
        $this->token = $token;
        $this->query = $query;
    }

    /**
     * @throws \WeForge\WeChat\Exceptions\InvalidSignatureException
     */
    public function __invoke(array $data): array
    {
        $attributes = [$this->token, $this->query['timestamp'], $this->query['nonce']];

        if ($this->isEncrypted()) {
            array_push($attributes, $data['Encrypt']);
            $this->validate($attributes, $this->query['msg_signature']);
        } else {
            $this->validate($attributes, $this->query['signature']);
        }

        return $data;
    }

    /**
     * Validate the signature
     *
     * @throws \WeForge\WeChat\Exceptions\InvalidSignatureException
     */
    protected function validate(array $attributes, string $signature): void
    {
        sort($attributes, SORT_STRING);

        if ($signature !== sha1(implode($attributes))) {
            throw new InvalidSignatureException;
        }
    }

    /**
     * @return bool
     */
    protected function isEncrypted()
    {
        return isset($this->query['encrypt_type']);
    }
}
