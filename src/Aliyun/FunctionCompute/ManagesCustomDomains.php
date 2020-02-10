<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

/**
 * @group 自定义域名管理
 */
trait ManagesCustomDomains
{
    /**
     * 自定义域名详情
     *
     * @param string $domain 域名
     *
     * @return mixed
     */
    public function getCustomDomain(string $domain)
    {
        return $this->requestResource('GET', "/{$this->apiVersion}/custom-domains/{$domain}");
    }

    /**
     * 自定义域名列表
     *
     * @return mixed
     */
    public function getCustomDomains()
    {
        return $this->requestResource('GET', "/{$this->apiVersion}/custom-domains");
    }

    /**
     * 创建自定义域名
     *
     * @param string $domain   域名
     * @param string $protocol 协议
     * @param array  $routes   路由
     * @param array  $certs    证书
     *
     * @return mixed
     */
    public function createCustomDomain($domain, $protocol, array $routes = [], array $certs = [])
    {
        return $this->requestResource('POST', "/{$this->apiVersion}/custom-domains", [
            'json' => array_filter([
                'DomainName' => $domain,
                'Protocol' => $protocol,
                'RouteConfig' => $routes,
                'CertConfig' => $certs,
            ]),
        ]);
    }

    public function updateCustomDomain($domain, $protocol, array $routes = [], array $certs = [])
    {
        return $this->requestResource('PUT', "/{$this->apiVersion}/custom-domains/{$domain}", [
            'json' => array_filter([
                'Protocol' => $protocol,
                'RouteConfig' => $routes,
                'CertConfig' => $certs,
            ]),
        ]);
    }

    public function deleteCustomDomain($domain)
    {
        return $this->requestResource('DELETE', "/{$this->apiVersion}/custom-domains/{$domain}");
    }
}
