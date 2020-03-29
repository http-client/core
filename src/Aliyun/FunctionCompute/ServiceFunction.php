<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

/**
 * @group 函数管理
 */
class ServiceFunction extends Client
{
    /**
     * 获取函数详情
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     *
     * @return mixed
     */
    public function get($serviceName, $functionName)
    {
        return $this->request('GET', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}");
    }

    /**
     * 获取函数列表
     *
     * @param string $serviceName 服务名称
     *
     * @return mixed
     */
    public function list($serviceName)
    {
        return $this->request('GET', "/{$this->apiVersion}/services/{$serviceName}/functions");
    }

    /**
     * 创建函数
     *
     * @param string $serviceName 服务名称
     *
     * @return mixed
     */
    public function create($serviceName, array $params)
    {
        return $this->request('POST', "/{$this->apiVersion}/services/{$serviceName}/functions", ['json' => $params]);
    }

    /**
     * 更新函数
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     *
     * @return mixed
     */
    public function update($serviceName, $functionName, array $params)
    {
        return $this->request('PUT', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}", ['json' => $params]);
    }

    /**
     * 删除函数
     *
     * @param string $serviceName  服务名称
     * @param string $functionName 函数名称
     *
     * @return mixed
     */
    public function delete($serviceName, $functionName)
    {
        return $this->request('DELETE', "/{$this->apiVersion}/services/{$serviceName}/functions/{$functionName}");
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
    public function invoke($serviceName, $functionName, array $body, bool $asynchronous = false)
    {
        return $this->request(
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
    public function invokeAsynchronously($serviceName, $functionName, array $body)
    {
        return $this->invoke($serviceName, $functionName, $body, true);
    }
}
