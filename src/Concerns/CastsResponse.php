<?php

namespace WeForge\Concerns;

use Psr\Http\Message\ResponseInterface;

trait CastsResponse
{
    /**
     * Casts response to string.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return string
     */
    public function castsResponseToString(ResponseInterface $response): string
    {
        $contents = $response->getBody()->getContents();
        $response->getBody()->rewind();

        return $contents;
    }

    /**
     * Casts response to array.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return array
     */
    public function castsResponseToArray(ResponseInterface $response): array
    {
        return json_decode(
            $this->castsResponseToString($response), true
        );
    }
}
