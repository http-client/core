<?php

declare(strict_types=1);

namespace HttpClient\Concerns;

use HttpClient\Exceptions\ResponseCastingErrorException;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;

trait CastsResponse
{
    /**
     * Casts response to string.
     */
    public function castsResponseToString(ResponseInterface $response): string
    {
        $contents = (string) $response->getBody();
        $response->getBody()->rewind();

        return $contents;
    }

    /**
     * Casts response to array.
     *
     * @throws \WeForge\Exceptions\ResponseCastingErrorException
     */
    public function castsResponseToArray(ResponseInterface $response): array
    {
        $string = $this->castsResponseToString($response);

        if ($string == '' && ($response->getStatusCode() >= 200 && $response->getStatusCode() < 299)) {
            return [];
        }

        if ($array = $this->tryCastJson($string)) {
            return $array;
        }

        if ($array = $this->tryCastXml($string)) {
            return $array;
        }

        throw (new ResponseCastingErrorException($string))->withResponse($response);
    }

    protected function tryCastJson($string)
    {
        $decoded = json_decode($string, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
    }

    protected function tryCastXml($string)
    {
        $previous = libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($string, SimpleXMLElement::class, LIBXML_NOCDATA)), true);
        libxml_disable_entity_loader($previous);

        if ($values) {
            return $values;
        }
    }
}
