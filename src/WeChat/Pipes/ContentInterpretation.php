<?php

declare(strict_types=1);

namespace HttpClient\WeChat\Pipes;

use HttpClient\Support\XMLLoader;
use HttpClient\WeChat\Exceptions\InterpretException;

class ContentInterpretation
{
    /**
     * @throws \HttpClient\WeChat\Exceptions\InterpretException
     */
    public function __invoke(string $content): array
    {
        if ($content === '') { // Empty string if is GET request.
            return [];
        }

        $parser = XMLLoader::load($content, null, LIBXML_COMPACT | LIBXML_NOCDATA | LIBXML_NOBLANKS);

        if ($parser->isOk()) {
            return json_decode(json_encode($parser->result()), true);
        }

        if (is_array($result = json_decode($content, true))) {
            return $result;
        }

        throw new InterpretException;
    }
}
