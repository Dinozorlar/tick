<?php

$app->get('/', function () use ($app) {
    $mainDB = $app->getDoctrine()->getConnection('haydar');

    foreach(range(1,50) as $step){
        $mainDB->insert('test',['test'=>$step.' nci denememiz']);
    }

    $getRows = $mainDB->fetchAll('select * from bostablo');

    $data = [
        'rows' => $getRows,
        'header' => 'merba'
    ];

    return $app->getTwig()->render('@app/list.twig', $data);
});

$app->get('/hello/{name}', function ($name) use ($app) {
    return $app['twig']->render('@app/hello.twig', [
        'name' => $name,
    ]);
})->bind('isimliHello');
