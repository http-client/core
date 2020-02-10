<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

trait ManagesCertificates
{
    /**
     * 查询所有已签发证书信息
     *
     * @return mixed
     */
    public function describeCertificates(array $params)
    {
        return $this->encapsulateRequest20180813([
            'Action' => 'DescribeCertificateList',
        ] + $params);
    }
}
