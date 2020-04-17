<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

class UserCertificate extends Client
{
    public function create($name, $cert, $key, array $params = [])
    {
        return $this->request([
            'Action' => 'CreateUserCertificate',
            'Cert' => $cert,
            'Key' => $key,
            'Name' => $name,
        ] + $params);
    }

    public function get($certId, array $params = [])
    {
        return $this->request([
            'Action' => 'DescribeUserCertificateDetail',
            'CertId' => $certId,
        ] + $params);
    }

    public function list(array $params = [])
    {
        return $this->request(array_merge([
            'Action' => 'DescribeUserCertificateList',
            'CurrentPage' => $params['CurrentPage'] ?? 1,
            'ShowSize' => $params['ShowSize'] ?? 50,
        ], $params));
    }
}
