<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

/**
 * @name sadf
 */
class CertificateAuthorityService extends Client
{
    use CertificateAuthorityService\EncapsulatesRequests,
        CertificateAuthorityService\ManagesDVOrders,
        CertificateAuthorityService\ManagesUserCertificates,
        CertificateAuthorityService\ManagesOrderInstances,
        CertificateAuthorityService\ManagesCertificates,
        CertificateAuthorityService\ManagesResources,
        CertificateAuthorityService\ManagesOrders;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://cas.aliyuncs.com';
}
