<?php

declare(strict_types=1);

namespace WeForge\Tests\Http;

class TestServer
{
    public static function host()
    {
        return 'localhost:9033';
    }

    public function run()
    {
        $pid = exec(sprintf('php -S %s -t ./runtime > /dev/null 2>&1 & echo $!', static::host()));
        dump('pid is: '.$pid);
        usleep(1000);

        // while (@file_get_contents('http://' . static::host() . '/foo') === false) {
        //     usleep(1000);
        // }

        register_shutdown_function(function () use ($pid) {
            dump('ready to kill'.$pid);
            exec('kill '.$pid);
        });
    }
}
