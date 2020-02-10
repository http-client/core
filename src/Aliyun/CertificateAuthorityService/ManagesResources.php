<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

trait ManagesResources
{
    /**
     * 查询 SSL 证书实例和标签的对应关系
     *
     * @return mixed
     */
    public function getTaggedResources(array $params)
    {
        return $this->encapsulateRequest20180813([
            'Action' => 'ListTagResources',
        ] + $params);
    }

    /**
     * 为 SSL 证书实例绑定标签
     *
     * @return mixed
     */
    public function tagResources(array $params)
    {
        return $this->encapsulateRequest20180813([
            'Action' => 'TagResources',
        ] + $params);
    }

    /**
     * 移除 SSL 证书实例标签
     *
     * @return mixed
     */
    public function untagResources(array $params)
    {
        return $this->encapsulateRequest20180813([
            'Action' => 'UntagResources',
        ] + $params);
    }
}
