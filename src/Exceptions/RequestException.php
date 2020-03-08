<?php

declare(strict_types=1);

namespace HttpClient\Exceptions;

use Exception;
use HttpClient\Response;

class RequestException extends Exception
{
    /**
     * The response instance.
     *
     * @var \HttpClient\Response
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct(Response $response)
    {
        parent::__construct(sprintf('%s returned status code %d', $response->transferStats->getEffectiveUri(), $response->getStatusCode()));

        $this->response = $response;
    }
}
