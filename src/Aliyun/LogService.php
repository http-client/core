<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class LogService extends Client
{
    use LogService\Sign;

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->setBaseUri('https://'.$this->options['endpoint']);
    }

    public function getProjects()
    {
        $headers = $this->authenticateWithHeaders('GET', '/');

        return $this->request('GET', '/', ['headers' => $headers]);
    }
}
