<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageService;

use HttpClient\Core\Application as BaseApplication;

class BucketApplication extends BaseApplication
{
    use AuthorizesUrls;

    /**
     * @return void
     */
    protected function boot()
    {
        $this['client'] = function ($pimple) {
            return new Client($pimple);
        };

        $this['object'] = function ($pimple) {
            return new BucketObject($pimple);
        };
    }

    public function info()
    {
        return $this['client']->request('GET', '/?bucketInfo');
    }

    public function create($acl = null)
    {
        return $this['client']->request('PUT', '/', [
            'headers' => array_filter([
                'x-oss-acl' => $acl,
            ]),
        ]);
    }

    public function delete()
    {
        return $this['client']->request('DELETE', '/');
    }
}
