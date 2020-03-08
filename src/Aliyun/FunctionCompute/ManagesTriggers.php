<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

/**
 * @group 触发器管理
 */
trait ManagesTriggers
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
    public function getTrigger(string $serviceName, string $functionName, string $triggerName)
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
    public function getTriggers(string $serviceName, string $functionName)
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
    public function createTrigger(string $serviceName, string $functionName, array $json)
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
    public function updateTrigger(string $serviceName, string $functionName, string $triggerName, array $json)
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
    public function deleteTrigger(string $serviceName, string $functionName, string $triggerName)
    {
        return $this->request(
            'DELETE', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}/triggers/{$triggerName}"
        );
    }
}
