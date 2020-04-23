<?php



namespace HttpClient\Concerns;

use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Monolog\Logger;

trait ResolvesLogger
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var callable
     */
    protected $resolveLoggerUsing;

    protected $loggerMessageFormat;

    /**
     * @return $this
     */
    public function resolveLoggerUsing(callable $callback)
    {
        $this->resolveLoggerUsing = $callback;

        return $this;
    }

    public function setLoggerMessageFormat($template)
    {
        $this->loggerMessageFormat = $template;

        return $this;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function resolveLogger()
    {
        return $this->logger ?: $this->logger = call_user_func($this->resolveLoggerUsing ?: function () {
            return new Logger('HttpClient');
        });
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function logger()
    {
        return $this->resolveLogger();
    }

    /**
     * @return callable
     */
    protected function loggerHandler()
    {
        return Middleware::log($this->logger(), new MessageFormatter($this->loggerMessageFormat ?: MessageFormatter::DEBUG));
    }
}
