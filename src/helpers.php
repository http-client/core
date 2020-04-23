<?php

namespace HttpClient;

function str_random($length = 16) {
    $value = '';
    $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';

    for ($i = 0; $i < $length; ++$i) {
        $value .= $pool[mt_rand(0, strlen($pool) - 1)];
    }

    return $value;
}
