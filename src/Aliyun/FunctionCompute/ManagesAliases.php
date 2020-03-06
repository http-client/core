<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

/**
 * @group 别名管理
 */
trait ManagesAliases
{
    /**
     * 获取别名
     *
     * @param string $serviceName 服务名称
     * @param string $aliasName   别名名称
     *
     * @return mixed
     */
    public function getAlias(string $serviceName, string $aliasName)
    {
        return $this->encapsulateRequest(
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
    public function getAliases(string $serviceName)
    {
        return $this->encapsulateRequest(
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
     * @param int         $additionalVersionWeight 权重吧
     *
     * @return mixed
     */
    public function createAlias(string $serviceName, string $aliasName, $versionId, string $description = null, $additionalVersionWeight = null)
    {
        $json = [
            'aliasName' => $aliasName,
            'versionId' => (string) $versionId,
            'description' => $description,
            'additionalVersionWeight' => $additionalVersionWeight,
        ];

        return $this->encapsulateRequest(
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
    public function updateAlias(string $serviceName, string $aliasName, $versionId, string $description = null, $additionalVersionWeight = null)
    {
        $json = [
            'versionId' => (string) $versionId,
            'description' => $description,
            'additionalVersionWeight' => $additionalVersionWeight,
        ];

        return $this->encapsulateRequest(
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
    public function deleteAlias(string $serviceName, string $aliasName)
    {
        return $this->encapsulateRequest(
            'DELETE', "/{$this->apiVersion}/services/{$serviceName}/aliases/{$aliasName}"
        );
    }
}
