<?php

declare(strict_types=1);

namespace WeForge\WeChat\Pipes;

use Symfony\Component\HttpFoundation\Request;

class ConvertRequestToString
{
    /**
     * Converts request object to string.
     */
    public function __invoke(Request $request): string
    {
        return $request->getContent();
    }
}
