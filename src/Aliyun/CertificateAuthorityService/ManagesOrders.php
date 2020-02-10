<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

trait ManagesOrders
{
    /**
     * 查询单个证书订单的详细信息
     *
     * @return mixed
     */
    public function describeOrders(array $params)
    {
        return $this->encapsulateRequest20180813([
            'Action' => 'DescribeOrderList',
        ] + $params);
    }
}
