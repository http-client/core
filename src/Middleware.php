<?php
namespace HttpClient;

use Countable;

class Middleware implements Countable
{
    protected $middleware = [];

    public function add($name, $middleware)
    {
        $this->middleware[$name] = $middleware;

        return $this;
    }

    public function remove($name)
    {
        unset($this->middleware[$name]);

        return $this;
    }

    public function all()
    {
        return $this->middleware;
    }

    public function count()
    {
        return count($this->middleware);
    }
}
