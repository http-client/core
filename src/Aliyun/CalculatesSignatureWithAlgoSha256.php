<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

trait CalculatesSignatureWithAlgoSha256
{
    protected function calculateSignature($method, $contentType, $date, array $canonicalizedHeaders = [], string $canonicalizedResource = '', $algo = 'sha256')
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
            strtoupper($method), $md5 = '', $contentType, $date, $canonicalizedHeadersString,
        ]).$canonicalizedResource;

        return base64_encode(
            hash_hmac($algo, $string, $this->options['access_key_secret'], true)
        );
    }
}
