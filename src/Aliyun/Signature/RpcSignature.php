<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\Signature;

class RpcSignature
{
    protected $withPercentEncoded = true;

    protected $requestMethod;

    public function __construct($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    public function withoutPercentEncoded()
    {
        $this->withPercentEncoded = false;

        return $this;
    }

    public function sign(array $parameters, $key_)
    {
        $parameters = array_filter($parameters, function ($value) {
            if (is_null($value)) {
                return false;
            }

            if (is_string($value)) {
                return trim($value) !== '';
            }

            return true;
        });

        ksort($parameters);

        $canonicalizedQueryString = '';

        foreach ($parameters as $key => $value) {
            $canonicalizedQueryString .= '&'.$this->percentEncode($key).'='.$this->percentEncode($value);
        }

        $string = implode('&', [
            $this->requestMethod,
            urlencode('/'),
            empty($canonicalizedQueryString) ? '' : $this->percentEncode(substr($canonicalizedQueryString, 1)),
        ]);

        return base64_encode(hash_hmac('sha1', $string, $key_.'&', true));
    }

    protected function percentEncode($string)
    {
        // if (! $this->withPercentEncoded) {
        //     return $string;
        // }

        $string = str_replace(
            ['+', '*'], ['%20', '%2A'], urlencode((string) $string)
        );

        return preg_replace('/%7E/', '~', $string);
    }
}
