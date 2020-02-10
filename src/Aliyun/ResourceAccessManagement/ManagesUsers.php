<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ResourceAccessManagement;

trait ManagesUsers
{
    public function getUsers()
    {
        $attributes = $this->mergeDefaultAuthenticationAttributes(['Action' => 'ListUsers']);

        $attributes['Signature'] = $this->calculateSignature($attributes);

        return $this->request('GET', '/', [
            'query' => $attributes,
        ]);
    }
}
