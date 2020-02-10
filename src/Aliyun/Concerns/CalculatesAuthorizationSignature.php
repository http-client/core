<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\Concerns;

trait CalculatesAuthorizationSignature
{
    protected function calculateAuthorizationSignature($method, $contentMd5, $contentType, $date, array $canonicalizedHeaders = [], string $canonicalizedResource = '', $algo = 'sha1')
    {
        $canonicalizedHeadersString = '';

        if (!empty($canonicalizedHeaders)) {
            $canonicalizedHeaders = array_change_key_case($canonicalizedHeaders, CASE_LOWER);

            ksort($canonicalizedHeaders);

            foreach ($canonicalizedHeaders as $key => $value) {
                $canonicalizedHeadersString .= $key.':'.$value."\n";
            }
        }

        $string = implode("\n", [
            strtoupper($method), $contentMd5, $contentType, $date, $canonicalizedHeadersString,
        ]).$canonicalizedResource;
// dd($this->options['access_key_secret']);
        return base64_encode(
            hash_hmac($algo, $string, $this->options['access_key_secret'], true)
        );
    }

    protected function calculateAuthorizationSignatureWithSha256($method, $contentMd5, $contentType, $date, $canonicalizedHeaders = [], $canonicalizedResource = '')
    {
        return $this->calculateAuthorizationSignature(
            $method, $contentMd5, $contentType, $date, $canonicalizedHeaders, $canonicalizedResource, 'sha256'
        );
    }
}
