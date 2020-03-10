<?php

declare(strict_types=1);

namespace HttpClient\Core;

use ArrayAccess;
use HttpClient\Exceptions\RequestException;
use LogicException;

class Response implements ArrayAccess
{
    /**
     * The PSR response.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * The body of the response.
     *
     * @var string
     */
    // public $body;

    /**
     * Create a new response instance.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     */
    public function __construct($response)
    {
        $this->response = $response;
        // $this->body = $this->response->getContent();
    }

    /**
     * Throw an exception if a server or client error occurred.
     *
     * @return $this
     *
     * @throws \HttpClient\Exceptions\RequestException
     */
    public function throw()
    {
        if ($this->getStatusCode() >= 400) {
            throw new RequestException($this);
        }

        return $this;
    }

    /**
     * Determine if the given offset exists.
     *
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->toArray()[$offset]);
    }

    /**
     * Get the value for a given offset.
     *
     * @param string $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->toArray()[$offset];
    }

    /**
     * Set the value at the given offset.
     *
     * @param string $offset
     * @param mixed  $value
     *
     * @return void
     *
     * @throws \LogicException
     */
    public function offsetSet($offset, $value)
    {
        throw new LogicException('Response data may not be mutated using array access.');
    }

    /**
     * Unset the value at the given offset.
     *
     * @param string $offset
     *
     * @return void
     *
     * @throws \LogicException
     */
    public function offsetUnset($offset)
    {
        throw new LogicException('Response data may not be mutated using array access.');
    }

    public function headers()
    {
        return $this->getHeaders(false);
    }

    /**
     * Get the array of the response.
     *
     * @return array
     */
    public function toArray()
    {
        if (($this->getHeaders()['content-type'][0] ?? null) === 'application/xml') {
            $previous = libxml_disable_entity_loader(true);
            $values = json_decode(json_encode(simplexml_load_string($this->__toString(), \SimpleXMLElement::class, LIBXML_NOCDATA)), true);
            libxml_disable_entity_loader($previous);

            return $values;
        }

        return $this->response->toArray(false);
    }

    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getContent(false);
    }

    /**
     * Dynamically proxy other methods to the underlying response.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->response->{$method}(...$parameters);
    }
}
