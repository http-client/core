<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

trait ManagesOrderInstances
{
    /**
     * 查询证书订单实例列表
     *
     * @param int         $startIndex
     * @param string|null $lang
     *
     * @return mixed
     */
    public function describeOrderInstances($startIndex, $lang = null)
    {
        return $this->encapsulateRequest([
            'Action' => 'DescribeOrderInstanceList',
            'StartIndex' => $startIndex,
            'Lang' => $lang,
        ]);
    }
}
