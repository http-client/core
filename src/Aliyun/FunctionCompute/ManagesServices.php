<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

/**
 * @group 服务管理
 */
trait ManagesServices
{
    /**
     * 获取服务信息
     *
     * @param string $name 服务名称
     *
     * @return mixed
     */
    public function getService($name)
    {
        return $this->requestResource('GET', "/{$this->apiVersion}/services/{$name}");
    }

    /**
     * 获取服务
     *
     * @return mixed
     */
    public function getServices()
    {
        return $this->requestResource('GET', "/{$this->apiVersion}/services");
    }

    /**
     * 创建服务
     *
     * @return mixed
     */
    public function createService(array $params)
    {
        return $this->requestResource('POST', "/{$this->apiVersion}/services", ['json' => $params]);
    }

    /**
     * 更新服务
     *
     * @param string $name 服务名称
     *
     * @return mixed
     */
    public function updateService(string $name, array $params)
    {
        return $this->requestResource('PUT', "/{$this->apiVersion}/services/{$name}", ['json' => $params]);
    }

    /**
     * 删除服务
     *
     * @param string $name 服务名称
     *
     * @return mixed
     */
    public function deleteService(string $name)
    {
        return $this->requestResource('DELETE', "/{$this->apiVersion}/services/{$name}");
    }
}
