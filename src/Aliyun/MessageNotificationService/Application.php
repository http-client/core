<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\MessageNotificationService;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @return void
     */
    protected function boot()
    {
        $this['queue'] = function ($pimple) {
            return new Queue($pimple);
        };

        $this['queue_message'] = function ($pimple) {
            return new QueueMessage($pimple);
        };
    }
}
