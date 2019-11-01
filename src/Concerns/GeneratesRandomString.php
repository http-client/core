<?php

declare(strict_types=1);

namespace WeForge\Concerns;

trait GeneratesRandomString
{
    /**
     * @param int $length
     *
     * @return string
     */
    protected function generateRandomString(int $length = 16): string
    {
        $value = '';
        $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';

        for ($i = 0; $i < $length; ++$i) {
            $value .= $pool[mt_rand(0, strlen($pool) - 1)];
        }

        return $value;
    }
}
