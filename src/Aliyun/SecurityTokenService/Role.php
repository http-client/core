<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\SecurityTokenService;

class Role extends Client
{
    public function assume($arn, $sessionName, array $policy = null, int $durationSeconds = null)
    {
        // $policy = '{"Statement": [{"Action": ["*"],"Effect": "Allow","Resource": ["*"]}],"Version":"1"}';

        return $this->request([
            'Action' => 'AssumeRole',
            'RoleArn' => $arn,
            'RoleSessionName' => $sessionName,
            'Policy' => $policy,
            'DurationSeconds' => $durationSeconds,
        ]);

        // $query['Signature'] = $this->calculateSignature(array_filter($query), $this->options['access_key_secret']);

        // return $this->request('GET', '/', compact('query'));
    }
}
