<?php

declare(strict_types=1);

namespace HttpClient\Support;

class Str
{
    public static function random($length = 16)
    {
        $value = '';
        $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';

        for ($i = 0; $i < $length; ++$i) {
            $value .= $pool[mt_rand(0, strlen($pool) - 1)];
        }

        return $value;
    }

    /*
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     * @return bool
     */
    // public static function startsWith($haystack, $needles)
    // {
    //     foreach ((array) $needles as $needle) {
    //         if ((string) $needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }
}
