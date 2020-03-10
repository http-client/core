<?php

require 'vendor/autoload.php';



// $oss = new HttpClient\Aliyun\ObjectStorageService\Application($options);
$fc = new HttpClient\Aliyun\FunctionCompute\Application($options);
// $response = $oss->service->list();
// $ossBucket = $oss->bucket();
// $response = $oss->bucket('weforge')->info();
// $response = $oss->bucket('weforge')->create();
// $response = $oss->bucket('weforge')->delete();
// $response = $oss->bucket('weforge')->object->get('weforge-presenter-0.1.1.zip');
// $response = $oss->bucket('weforge')->object->head('weforge-presenter-0.1.1.zip');
// $response = $oss->bucket('weforge')->object->put('test.txt', 'teststirng');
// $response = $oss->bucket('weforge')->getSignedUrlForPuttingObject('test.txt');

// $response = $fc->service->list();
// $response = $fc->service->get('weforge-qqq');
// $response = $fc->function->list('weforge-qqq');
// $response = $fc->function->get('weforge-qqq', 'weforge-qqq-staging');
// $response = $fc->alias->list('weforge-qqq');
// $response = $fc->alias->get('weforge-qqq', 'staging');
// $response = $fc->trigger->list('weforge-qqq', 'staging');

// var_dump($response->getInfo());
// var_dump($response['Owner']);die;
// echo $response;
var_dump($response->toArray());
// echo $response->getStatusCode();
// var_dump($response->headers());
