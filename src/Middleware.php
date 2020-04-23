<?php

namespace HttpClient;

class Middleware
{
    /**
     * @var array
     */
    protected $middleware = [];

    /**
     * @param $name
     * @param $middleware
     *
     * @return $this
     */
    public function add($name, $middleware)
    {
        $this->middleware[$name] = $middleware;

        return $this;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function remove($name)
    {
        unset($this->middleware[$name]);

        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->middleware;
    }
}
