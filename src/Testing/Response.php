<?php

namespace HttpClient\Testing;

use function GuzzleHttp\Promise\promise_for;
use GuzzleHttp\Psr7\Response as Psr7Response;

class Response
{
    public static function create($body = null, $status = 200, $headers = [])
    {
        if (is_array($body)) {
            $body = json_encode($body);

            $headers['Content-Type'] = 'application/json';
        }

        return promise_for(new Psr7Response($status, $headers, $body));
    }
}
