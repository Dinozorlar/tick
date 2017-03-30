<?php
$app->get('/', function () {
    return "hello";
});

$app->get('/hello/{name}', function ($name) use ($app){
    return $app['twig']->render('@app/hello.twig', [
        'name' => $name
    ]);
})->bind('isimliHello');