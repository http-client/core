<?php

namespace HttpClient\Testing;

class ResponseSequence
{
    /**
     * The responses in the request sequence.
     *
     * @var array
     */
    protected $responses;

    /**
     * Create a new instance.
     */
    public function __construct(array $responses)
    {
        $this->responses = $responses;
    }

    /**
     * Push a response to the sequence.
     *
     * @param  string|array  $body
     * @param  int  $status
     * @param  array  $headers
     * @return $this
     */
    public function push($body = '', int $status = 200, array $headers = [])
    {
        // $body = is_array($body) ? json_encode($body) : $body;

        return $this->pushResponse(
            Factory::response($body, $status, $headers)
        );
    }

    /**
     * Push a response to the sequence.
     *
     * @param  mixed  $response
     * @return $this
     */
    public function pushResponse($response)
    {
        $this->responses[] = $response;

        return $this;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        return array_shift($this->responses);
    }
}
