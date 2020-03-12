<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogService;

use HttpClient\Core\Application as BaseApplication;

class ProjectApplication extends BaseApplication
{
    /**
     * @return void
     */
    protected function boot()
    {
        $this['client'] = function ($pimple) {
            return new Client($pimple);
        };

        $this['log'] = function ($pimple) {
            return new ProjectLog($pimple);
        };

        $this['logstore'] = function ($pimple) {
            return new ProjectLogstore($pimple);
        };
    }

    public function info()
    {
        return $this['client']->request('GET', '/');
    }
}
