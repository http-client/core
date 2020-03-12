<?php

declare(strict_types=1);

namespace HttpClient\Core;

use Exception;

class RequestException extends Exception
{
    /**
     * The response instance.
     *
     * @var \HttpClient\Core\Response
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param \HttpClient\Core\Response $response
     *
     * @return void
     */
    public function __construct(Response $response)
    {
        parent::__construct(sprintf('%s returned status code %d', 'wip', $response->getStatusCode()), $response->getStatusCode());

        $this->response = $response;
    }
}
