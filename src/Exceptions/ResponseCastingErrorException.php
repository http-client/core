<?php

declare(strict_types=1);

namespace WeForge\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

class ResponseCastingErrorException extends Exception
{
    /**
     * @var \Psr\Http\Message\ResponseInterface|null
     */
    protected $response;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return $this
     */
    public function withResponse(ResponseInterface $response): self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
