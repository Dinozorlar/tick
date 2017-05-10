<?php
/** @var \Tick\Application $app */
$app = require dirname(__DIR__) . '/src/app.php';

$cli = new \Saxulum\Console\Console\ConsoleApplication($app);

$commands = [
    new \Tick\ConsoleCommands\CreateDefaultUsers()
];

$cli->getHelperSet()->set(
    new \Saxulum\DoctrineOrmCommands\Helper\ManagerRegistryHelper($app->getDoctrine()),
    'doctrine'
);

$cli->addCommands($commands);
$cli->run();