<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

class Trigger extends Client
{
    /**
     * 触发器详情
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     * @param string $triggerName  触发器名称
     *
     * @return mixed
     */
    public function get($serviceName, $functionName, $triggerName)
    {
        return $this->request(
            'GET', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}/triggers/{$triggerName}"
        );
    }

    /**
     * 获取触发器列表
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     *
     * @return mixed
     */
    public function list($serviceName, $functionName)
    {
        return $this->request(
            'GET', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}/triggers"
        );
    }

    /**
     * 创建触发器
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     *
     * @return mixed
     */
    public function create($serviceName, $functionName, array $json)
    {
        return $this->request(
            'POST', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}/triggers", compact('json')
        );
    }

    /**
     * 更新触发器
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     * @param string $triggerName  触发器名称
     *
     * @return mixed
     */
    public function update($serviceName, $functionName, $triggerName, array $json)
    {
        return $this->request(
            'PUT', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}/triggers/{$triggerName}", compact('json')
        );
    }

    /**
     * 删除触发器
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     * @param string $triggerName  触发器名称
     *
     * @return mixed
     */
    public function delete($serviceName, $functionName, $triggerName)
    {
        return $this->request(
            'DELETE', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}/triggers/{$triggerName}"
        );
    }
}
