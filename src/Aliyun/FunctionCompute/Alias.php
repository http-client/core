<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

/**
 * @group 别名管理
 */
class Alias extends Client
{
    /**
     * 获取别名
     *
     * @param string $serviceName 服务名称
     * @param string $aliasName   别名名称
     *
     * @return mixed
     */
    public function get($serviceName, $aliasName)
    {
        return $this->request(
            'GET', "/{$this->apiVersion}/services/{$serviceName}/aliases/{$aliasName}"
        );
    }

    /**
     * 获取别名列表
     *
     * @param string $serviceName 服务名称
     *
     * @return mixed
     */
    public function list($serviceName)
    {
        return $this->request(
            'GET', "/{$this->apiVersion}/services/{$serviceName}/aliases"
        );
    }

    /**
     * 创建别名
     *
     * @param string      $serviceName             服务名称
     * @param string      $aliasName               别名名称
     * @param string      $versionId               版本 ID
     * @param string|null $description             别名描述
     * @param int         $additionalVersionWeight 权重
     *
     * @return mixed
     */
    public function create($serviceName, $aliasName, $versionId, $description = null, $additionalVersionWeight = null)
    {
        $json = [
            'aliasName' => $aliasName,
            'versionId' => (string) $versionId,
            'description' => $description,
            'additionalVersionWeight' => $additionalVersionWeight,
        ];

        return $this->request(
            'POST', "/{$this->apiVersion}/services/{$serviceName}/aliases", compact('json')
        );
    }

    /**
     * 更新别名
     *
     * @param string $serviceName             服务名称
     * @param string $versionId               版本 ID
     * @param string $description             描述
     * @param int    $additionalVersionWeight 权重
     *
     * @return mixed
     */
    public function update($serviceName, $aliasName, $versionId, $description = null, $additionalVersionWeight = null)
    {
        $json = [
            'versionId' => (string) $versionId,
            'description' => $description,
            'additionalVersionWeight' => $additionalVersionWeight,
        ];

        return $this->request(
            'PUT', "/{$this->apiVersion}/services/{$serviceName}/aliases/{$aliasName}", compact('json')
        );
    }

    /**
     * 删除别名
     *
     * @param string $serviceName 服务名称
     * @param string $aliasName   别名名称
     *
     * @return mixed
     */
    public function delete($serviceName, $aliasName)
    {
        return $this->request(
            'DELETE', "/{$this->apiVersion}/services/{$serviceName}/aliases/{$aliasName}"
        );
    }
}
