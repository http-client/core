<?php

declare(strict_types=1);

namespace HttpClient\Support;

use Closure;
use SimpleXMLElement;

class XMLLoader
{
    /**
     * @var array|null
     */
    protected $errors;

    /**
     * @var \SimpleXMLElement|null
     */
    protected $result;

    /**
     * @param array $args
     *
     * @return static
     */
    public static function load(...$args)
    {
        return (new static)->withSimpleXmlLoadStringErrorHandling(function () use ($args) {
            $this->result = simplexml_load_string(...$args);
        });
    }

    /**
     * @return $this
     */
    protected function withSimpleXmlLoadStringErrorHandling(Closure $callback)
    {
        return $this->ensureEntityLoaderDisabled(function () use ($callback) {
            $previous = libxml_use_internal_errors(true);
            call_user_func($callback->bindTo($this));
            $this->errors = libxml_get_errors();
            libxml_use_internal_errors($previous);
        });
    }

    /**
     * Disable the ability to load external entities.
     *
     * @return $this
     */
    protected function ensureEntityLoaderDisabled(Closure $callback)
    {
        $previous = libxml_disable_entity_loader(true);
        call_user_func($callback);
        libxml_disable_entity_loader($previous);

        return $this;
    }

    /**
     * Determine whether the given xml is valid.
     *
     * @return bool
     */
    public function isOk()
    {
        return empty($this->errors());
    }

    /**
     * Get the parsed result.
     */
    public function result(): SimpleXMLElement
    {
        return $this->result;
    }

    /**
     * @return array|null
     */
    public function errors()
    {
        return $this->errors;
    }
}
