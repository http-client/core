<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

/**
 * @group DV 订单
 */
trait ManagesDVOrders
{
    /**
     * 提交 DV 订单
     *
     * @return mixed
     */
    public function createDVOrder(array $params)
    {
        return $this->encapsulateRequest([
            'Action' => 'CreateDVOrderAudit',
        ] + $params);
    }

    /**
     * 查询 DV 订单的详细信息
     *
     * @param string      $instanceId
     * @param string|null $lang
     *
     * @return mixed
     */
    public function describeDVOrderResult($instanceId, $lang = null)
    {
        return $this->encapsulateRequest([
            'Action' => 'DescribeDVOrderResult',
            'InstanceId' => $instanceId,
            'Lang' => $lang,
        ]);
    }
}
