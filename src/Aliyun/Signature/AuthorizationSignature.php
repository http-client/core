<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\Signature;

class AuthorizationSignature
{
    public static function sign($method, $contentMd5, $contentType, $date, array $canonicalizedHeaders, $canonicalizedResource, $accessKeySecret, $algo = 'sha1')
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
            hash_hmac($algo, $string, $accessKeySecret, true)
        );
    }
}
