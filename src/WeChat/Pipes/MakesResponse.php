<?php

declare(strict_types=1);

namespace WeForge\WeChat\Pipes;

use Symfony\Component\HttpFoundation\Response;
use WeForge\Concerns\ObservesHandler;
use WeForge\WeChat\Decorators\FinallyResult;

class MakesResponse
{
    use ObservesHandler;

    /**
     * @var array
     */
    protected $handlers;

    /**
     * @param array $handlers
     */
    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @param array $payload
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(array $payload): Response
    {
        $results = array_map(function ($handler) use ($payload) {
            return $this->observe($handler, $payload);
        }, $this->handlers);

        return new Response(
            $this->getFinallyResult($results)
        );
    }

    /**
     * Get the finally response.
     *
     * @param mixed $results
     *
     * @return string
     */
    protected function getFinallyResult($results): string
    {
        foreach ($results as $result) {
            if ($result instanceof FinallyResult) {
                return $result->content;
            }

            if (is_string($result)) {
                return $result;
            }
        }

        return '';
    }
}
