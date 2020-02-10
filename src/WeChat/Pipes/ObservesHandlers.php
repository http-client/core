<?php

declare(strict_types=1);

namespace HttpClient\WeChat\Pipes;

use HttpClient\Concerns\ObservesHandler;
use HttpClient\WeChat\Concerns\ConcatenatesResponseMessage;
use HttpClient\WeChat\Decorators\FinallyResult;
use Symfony\Component\HttpFoundation\Response;

class ObservesHandlers
{
    use ObservesHandler, ConcatenatesResponseMessage;

    /**
     * @var array
     */
    protected $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @return mixed
     */
    public function __invoke(array $payload)
    {
        $results = array_map(function ($handler) use ($payload) {
            return $this->observe($handler, $payload);
        }, $this->handlers);

        foreach ($results as $result) {
            if ($result instanceof FinallyResult) {
                return $result;
            }

            if (is_scalar($result)) {
                return $this->concatReplyMessage($payload['FromUserName'], $payload['ToUserName'], $result);
            }

            if ($result instanceof Response) {
                return $result;
            }
        }
    }
}
