<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

trait CanonicalizedResource
{
    protected function handleResourceQuery(array $query)
    {
        $query = array_filter($query);
        ksort($query);

        $canonicalizedQueryString = '';

        foreach ($query as $key => $value) {
            $canonicalizedQueryString .= '&'.$this->percentEncode($key).'='.$this->percentEncode($value);
        }

        return [
            $query, $this->percentEncode(substr($canonicalizedQueryString, 1)),
        ];
    }

    protected function percentEncode($str)
    {
        // return $str; // fuck 一些要一些不要
        return preg_replace(
            '/%7E/', '~', str_replace(['+', '*'], ['%20', '%2A'], urlencode($str))
        );
    }
}
