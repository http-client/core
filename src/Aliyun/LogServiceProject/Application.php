<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogServiceProject;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @return void
     */
    protected function boot()
    {
        $this['log'] = function ($pimple) {
            return new Log($pimple);
        };

        $this['logstore'] = function ($pimple) {
            return new Logstore($pimple);
        };
    }

    public function info()
    {
        return $this->request('GET', '/');
    }
}
