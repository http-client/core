<?php

namespace HttpClient\Testing;

use function GuzzleHttp\Promise\promise_for;
use GuzzleHttp\Psr7\Response;

class Factory
{
    public static function response($body = null, $status = 200, $headers = [])
    {
        if (is_array($body)) {
            $body = json_encode($body);

            $headers['Content-Type'] = 'application/json';
        }

        return promise_for(new Response($status, $headers, $body));
    }

    public static function sequence($responses = [])
    {
        return new ResponseSequence($responses);
    }
}
