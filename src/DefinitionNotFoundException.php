<?php

namespace HttpClient;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

class DefinitionNotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
    //
}
