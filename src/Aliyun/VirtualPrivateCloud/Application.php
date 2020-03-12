<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://vpc.aliyuncs.com';

    /**
     * @return void
     */
    protected function boot()
    {
        $this['client'] = function ($pimple) {
            return new Client($pimple);
        };

        $this['switch'] = function ($pimple) {
            return new VSwitch($pimple);
        };
    }

    public function get($vpcId, $regionId, array $params = [])
    {
        return $this['client']->request([
            'Action' => 'DescribeVpcAttribute',
            'RegionId' => $regionId,
            'VpcId' => $vpcId,
        ] + $params);
    }

    public function list($regionId)
    {
        return $this['client']->request([
            'Action' => 'DescribeVpcs',
            'RegionId' => $regionId,
        ]);
    }

    public function create(array $params)
    {
        return $this['client']->request(array_merge(['Action' => 'CreateVpc'], $params));
    }
}
