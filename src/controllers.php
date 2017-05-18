<?php

$app->get('/', function () use ($app) {
    return $app->getTwig()->render('@app/list.twig');
    $em = $app->getDoctrine()->getManager('tick');

    $limit = 100;
    $i = 1;

    $faker = Faker\Factory::create();

    while ($i <= 100) {
        $user = new \Tick\Entity\User();
        $user->setUsername($faker->userName);
        $user->setName($faker->name);
        $user->setLastName($faker->lastName);
        $user->setFullname($user->getName() . ' ' . $user->getLastName());
        $user->setEmail($faker->email);
        $user->setPassword($faker->password);
        $user->setSalt($faker->password);

        $em->persist($user);

        if ($i % 35 === 0) {
            $em->flush();
        }

        $i++;
    }

    $em->flush();

    return $app->getTwig()->render('@app/list.twig');
});

$app->get('/list', function () use ($app) {
    $em = $app->getDoctrine()->getManager('tick');

    $users = $em->createQuery(
        'SELECT user FROM Tick\Entity\User as user'
    )->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    return $app->getTwig()->render('@app/sonuclar.twig', ['users' => $users]);
});

$app->get('/hello/{name}', function ($name) use ($app) {
    return $app['twig']->render('@app/hello.twig', [
        'name' => $name,
    ]);
})->bind('isimliHello');
