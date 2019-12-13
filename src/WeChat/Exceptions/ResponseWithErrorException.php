<?php

declare(strict_types=1);

namespace WeForge\WeChat\Exceptions;

use RuntimeException;

class ResponseWithErrorException extends RuntimeException
{
    /**
     * @return static
     */
    public static function withResult(array $result)
    {
        return new static(
            sprintf('[%d] %s', $result['errcode'], $result['errmsg']),
            $result['errcode']
        );
    }
}
