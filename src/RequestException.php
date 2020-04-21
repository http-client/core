<?php

declare(strict_types=1);

namespace HttpClient;

use Exception;

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
     * @param \HttpClient\Response $response
     *
     * @return void
     */
    public function __construct(Response $response)
    {
        parent::__construct(sprintf('HTTP request returned status code %d.', $response->getStatusCode()));

        $this->response = $response;
    }
}
