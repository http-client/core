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
     * @return mixed
     */
    public function __invoke()
    {
        return array_shift($this->responses);
    }
}
