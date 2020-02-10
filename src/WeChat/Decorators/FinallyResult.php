<?php

declare(strict_types=1);

namespace HttpClient\WeChat\Decorators;

class FinallyResult
{
    /**
     * @var mixed
     */
    public $content;

    /**
     * @param mixed $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }
}
