<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogService;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @return void
     */
    protected function boot()
    {
        $this['project'] = function ($pimple) {
            return new Project($pimple);
        };
    }

    public function project($name)
    {
        return new ProjectApplication(array_merge($this['options'], [
            'bucket' => $name,
            'http' => [
                'base_uri' => $this->prependBaseUri($name),
            ],
        ]));
    }
}
