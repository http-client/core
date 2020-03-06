<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

/**
 * @group 函数管理
 */
trait ManagesFunctions
{
    /**
     * 获取函数详情
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     *
     * @return mixed
     */
    public function getFunction(string $serviceName, string $functionName)
    {
        return $this->encapsulateRequest('GET', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}");
    }

    /**
     * 获取函数列表
     *
     * @param string $serviceName 服务名称
     *
     * @return mixed
     */
    public function getFunctions(string $serviceName)
    {
        return $this->encapsulateRequest('GET', "/{$this->apiVersion}/services/{$serviceName}/functions");
    }

    /**
     * 创建函数
     *
     * @param string $serviceName 服务名称
     *
     * @return mixed
     */
    public function createFunction(string $serviceName, array $params)
    {
        return $this->encapsulateRequest('POST', "/{$this->apiVersion}/services/{$serviceName}/functions", ['json' => $params]);
    }

    /**
     * 更新函数
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     *
     * @return mixed
     */
    public function updateFunction(string $serviceName, string $functionName, array $params)
    {
        return $this->encapsulateRequest('PUT', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}", ['json' => $params]);
    }

    /**
     * 删除函数
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     *
     * @return mixed
     */
    public function deleteFunction(string $serviceName, string $functionName)
    {
        return $this->encapsulateRequest('DELETE', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}");
    }

    /**
     * 触发函数
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     * @param bool   $asynchronous 异步触发
     *
     * @return mixed
     */
    public function invokeFunction(string $serviceName, string $functionName, array $body, bool $asynchronous = false)
    {
        return $this->encapsulateRequest(
            'POST',
            "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}/invocations",
            ['json' => $body],
            ['X-Fc-Invocation-Type' => $asynchronous ? 'Async' : 'Sync']
        );
    }

    /**
     * 异步触发函数
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     *
     * @return mixed
     */
    public function invokeFunctionAsynchronously(string $serviceName, string $functionName, array $body)
    {
        return $this->invokeFunction($serviceName, $functionName, $body, true);
    }
}
