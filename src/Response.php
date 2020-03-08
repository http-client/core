<?php

declare(strict_types=1);

namespace HttpClient;

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
     * The transfer stats for the request.
     *
     * \GuzzleHttp\TransferStats
     */
    public $transferStats;

    /**
     * The decoded response.
     *
     * @var array
     */
    protected $array;

    /**
     * Create a new response instance.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \GuzzleHttp\TransferStats           $transferStats
     *
     * @return mixed
     */
    public function __construct($response, $transferStats)
    {
        $this->response = $response;
        $this->transferStats = $transferStats;

        if ($this->getStatusCode() >= 400) {
            throw new RequestException($this);
        }
    }

    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function body()
    {
        return (string) $this->response->getBody();
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

    /**
     * Get the array of the response.
     *
     * @return array
     */
    public function toArray()
    {
        if (!$this->array) {
            $this->array = json_decode((string) $this->response->getBody(), true);
        }

        return $this->array;
    }

    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->body();
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
