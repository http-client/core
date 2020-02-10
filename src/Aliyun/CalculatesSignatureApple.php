<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

trait CalculatesSignatureApple
{
    use CanonicalizedResource;

    protected function calculateSignature(array $query)
    {
        [$query, $str] = $this->handleResourceQuery($query);
        // $query=    array_filter($query);
        // ksort($query);

        // $canonicalizedQueryString = '';

        // foreach ($query as $key => $value) {
        //     $canonicalizedQueryString .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        // }

        // $stringToBeSigned = 'GET' . '&%2F&' . $this->percentEncode(substr($canonicalizedQueryString, 1));
        $stringToBeSigned = 'GET'.'&%2F&'.$str;

        return base64_encode(hash_hmac('sha1', $stringToBeSigned, $this->options['access_key_secret'].'&', true));
    }
}
