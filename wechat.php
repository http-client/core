<?php

require 'vendor/autoload.php';

$c = new OpenPlatform([
    'app_id' => 'xxx',
]);

// set on runtime.
$c->castsResponseUsing(MyCasting::class);

// disable on runtime.
$c->withoutResponseCasting();
