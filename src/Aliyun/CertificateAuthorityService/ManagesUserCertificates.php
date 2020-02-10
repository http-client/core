<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

/**
 * @group 证书管理
 */
trait ManagesUserCertificates
{
    /**
     * 查询证书列表
     *
     * @param int|null    $page 当前页码
     * @param int|null    $size 每页显示多少条记录
     * @param string|null $lang 请求和接收消息的语言类型
     *
     * @return mixed
     */
    public function describeUserCertificates($page = null, $size = null, $lang = null)
    {
        return $this->encapsulateRequest([
            'Action' => 'DescribeUserCertificateList',
            'CurrentPage' => $page,
            'ShowSize' => $size,
            'Lang' => $lang,
        ]);
    }

    /**
     * 查询单个证书的详细信息
     *
     * @param string      $certId 证书 ID
     * @param string|null $lang
     *
     * @return mixed
     */
    public function describeUserCertificate($certId, $lang = null)
    {
        return $this->encapsulateRequest([
            'Action' => 'DescribeUserCertificateDetail',
            'CertId' => $certId,
            'Lang' => $lang,
        ]);
    }

    /**
     * 删除用户的证书文件
     *
     * @param string      $certId
     * @param string|null $lang
     *
     * @return mixed
     */
    public function deleteUserCertificate($certId, $lang = null)
    {
        return $this->encapsulateRequest([
            'Action' => 'DeleteUserCertificate',
            'CertId' => $certId,
            'Lang' => $lang,
        ]);
    }

    /**
     * 添加证书
     *
     * @return mixed
     */
    public function createUserCertificate(array $params)
    {
        return $this->encapsulateRequest([
            'Action' => 'CreateUserCertificate',
        ] + $params);
    }
}
