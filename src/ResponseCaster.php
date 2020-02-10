<?php

declare(strict_types=1);

namespace HttpClient;

use HttpClient\Concerns\CastsResponse;
use Psr\Http\Message\ResponseInterface;

class ResponseCaster
{
    use CastsResponse;

    public static function toArray(ResponseInterface $response)
    {
        return (new static)->castsResponseToArray($response);
    }
}
