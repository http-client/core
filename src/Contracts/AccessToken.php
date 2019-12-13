<?php

declare(strict_types=1);

namespace WeClient\Contracts;

interface AccessToken
{
    /**
     * @return string
     */
    public function getToken();

    /**
     * @return string
     */
    public function refreshToken();
}
