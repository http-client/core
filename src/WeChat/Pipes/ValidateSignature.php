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
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $nonce;

    /**
     * @param string $token
     * @param string $signature
     * @param string $timestamp
     * @param string $nonce
     */
    public function __construct(string $token, string $signature, string $timestamp, string $nonce)
    {
        $this->token = $token;
        $this->signature = $signature;
        $this->timestamp = $timestamp;
        $this->nonce = $nonce;
    }

    /**
     * @param string $content
     *
     * @return string
     *
     * @throws \WeForge\WeChat\Exceptions\InvalidSignatureException
     */
    public function __invoke(string $content): string
    {
        $attributes = [$content, $this->token, $this->timestamp, $this->nonce];
        sort($attributes, SORT_STRING);

        if ($this->signature !== sha1(implode($attributes))) {
            throw new InvalidSignatureException;
        }

        return $content;
    }
}
