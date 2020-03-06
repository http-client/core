<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class SecurityTokenService extends Client
{
    use SecurityTokenService\EncapsulatesRequests,
        SecurityTokenService\ManagesRoles;

    // public function __constructx(array $options = [])
    // {
    //     parent::__construct($options);

    //     $this->setBaseUri('https://'.$this->options['endpoint']);
    // }
}
