<?php

declare(strict_types=1);

namespace HttpClient\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

class ResponseCastingErrorException extends Exception
{
    /**
     * @var \Psr\Http\Message\ResponseInterface|null
     */
    protected $response;

    /**
     * @return $this
     */
    public function withResponse(ResponseInterface $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
