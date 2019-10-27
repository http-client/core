<?php

namespace WeForge\Concerns;

use Psr\Http\Message\ResponseInterface;

trait CastsResponse
{
    /**
     * Casts response to array.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return array
     */
    public function castsResponseToArray(ResponseInterface $response)
    {
        $result = $response->getBody()->getContents();

        return json_decode($result, true);
    }
}
