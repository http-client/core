<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageService;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @return void
     */
    protected function boot()
    {
        $this['service'] = function ($pimple) {
            return new Service($pimple);
        };
    }

    public function bucket($name)
    {
        return new BucketApplication(array_merge($this['options'], [
            'bucket' => $name,
            'http' => [
                'base_uri' => $this->prependBaseUri($name),
            ],
        ]));
    }
}
