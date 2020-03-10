<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

class Domain extends Client
{
    /**
     * 自定义域名详情
     *
     * @param string $domain 域名
     *
     * @return mixed
     */
    public function get(string $domain)
    {
        return $this->request('GET', "/{$this->apiVersion}/custom-domains/{$domain}");
    }

    /**
     * 自定义域名列表
     *
     * @return mixed
     */
    public function list()
    {
        return $this->request('GET', "/{$this->apiVersion}/custom-domains");
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
    public function create($domain, $protocol, array $routes = [], array $certs = [])
    {
        return $this->request('POST', "/{$this->apiVersion}/custom-domains", [
            'json' => array_filter([
                'DomainName' => $domain,
                'Protocol' => $protocol,
                'RouteConfig' => $routes,
                'CertConfig' => $certs,
            ]),
        ]);
    }

    public function update($domain, $protocol, array $routes = [], array $certs = [])
    {
        return $this->request('PUT', "/{$this->apiVersion}/custom-domains/{$domain}", [
            'json' => array_filter([
                'Protocol' => $protocol,
                'RouteConfig' => $routes,
                'CertConfig' => $certs,
            ]),
        ]);
    }

    public function delete($domain)
    {
        return $this->request('DELETE', "/{$this->apiVersion}/custom-domains/{$domain}");
    }
}
