<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\RelationalDatabaseService;

class Account extends Client
{
    public function create($instanceId, $name, $password, $type = null, $description = null)
    {
        return $this->request([
            'Action' => 'CreateAccount',
            'DBInstanceId' => $instanceId,
            'AccountName' => $name,
            'AccountPassword' => $password,
            'AccountType' => $type,
            'AccountDescription' => $description,
        ]);
    }

    public function list($instanceId, array $params = [])
    {
        return $this->request([
            'Action' => 'DescribeAccounts',
            'DBInstanceId' => $instanceId,
        ] + $params);
    }

    public function delete($instanceId, $accountName)
    {
        return $this->request([
            'Action' => 'DeleteAccount',
            'AccountName' => $accountName,
            'DBInstanceId' => $instanceId,
        ]);
    }
}
