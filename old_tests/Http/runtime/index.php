<?php

declare(strict_types=1);

require '../../../vendor/autoload.php';

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Application;

$app = new Application(
    realpath(__DIR__.'/../runtime/')
);

function build_response($request)
{
    return new JsonResponse([
        'url' => $request->url(),
        'method' => $request->method(),
        'query' => $request->query->all(),
        'json' => $request->json()->all(),
    ], 200);
}

$app->router->get('get', function () {
    return build_response(app('request'));
});

$app->router->post('post', function () {
    return build_response(app('request'));
});

$app->run();
