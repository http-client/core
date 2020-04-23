<?php



namespace HttpClient;

use ArrayAccess;
use JsonSerializable;
use LogicException;

class Response implements ArrayAccess, JsonSerializable
{
    /**
     * The http-client response instance.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    public $transferStats;

    /**
     * Create a new response instance.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return void
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * @param \GuzzleHttp\TransferStats $transferStats
     */
    public function setTransferStats($transferStats)
    {
        $this->transferStats = $transferStats;

        return $this;
    }

    /**
     * Get body from the response.
     *
     * @return array
     */
    public function body()
    {
        return (string) $this->response->getBody();
    }

    /**
     * Get headers from the response.
     *
     * @return array
     */
    public function headers()
    {
        return $this->getHeaders();
    }

    /**
     * Get the array of the response.
     *
     * @return array
     */
    public function toArray()
    {
        $content = $this->body();

        if (preg_match('/\bjson\b/i', $this->getHeaderLine('Content-Type'))) {
            $content = json_decode($content, true, 512, JSON_BIGINT_AS_STRING);

            return $content;
        }

        if (preg_match('/\bxml\b/i', $this->getHeaderLine('Content-Type'))) {
            $previous = libxml_disable_entity_loader(true);
            $values = json_decode(json_encode(simplexml_load_string($content, \SimpleXMLElement::class, LIBXML_NOCDATA)), true);
            libxml_disable_entity_loader($previous);

            return $values;
        }
    }

    public function jsonSerialize()
    {
        return $this->toArray();
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
