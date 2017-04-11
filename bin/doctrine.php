<?php
/** @var \Tick\Application $app */
$app = require dirname(__DIR__) . '/src/app.php';

$cli = new \Saxulum\Console\Console\ConsoleApplication($app);

$commands = [];
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\CreateDatabaseDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\DropDatabaseDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\CreateSchemaDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\UpdateSchemaDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\DropSchemaDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\RunDqlDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\RunSqlDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\ConvertMappingDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\GenerateEntitiesDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\ClearMetadataCacheDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\ClearQueryCacheDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\ClearResultCacheDoctrineCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\InfoDoctrineCommand();
$commands[] = new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand();
$commands[] = new \Saxulum\DoctrineOrmCommands\Command\Proxy\EnsureProductionSettingsDoctrineCommand();

$cli->getHelperSet()->set(
    new \Saxulum\DoctrineOrmCommands\Helper\ManagerRegistryHelper($app->getDoctrine()),
    'doctrine'
);

$cli->addCommands($commands);
$cli->run();