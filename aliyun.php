<?php

use WeClient\Aliyun\ObjectStorageService;

require 'vendor/autoload.php';

$client = new ObjectStorageService();

$response = $client->get('/');

var_dump($response->getBody()->getContents());
