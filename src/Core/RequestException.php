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
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \HttpClient\Core\Response          $response
     *
     * @return void
     */
    public function __construct($request, $response)
    {
        parent::__construct(sprintf('%s returned status code %d', $request->getUri(), $response->getStatusCode()), $response->getStatusCode());

        $this->response = $response;
    }
}
