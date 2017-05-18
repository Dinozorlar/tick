<?php

define('APP_ROOT_DIR', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
define('APP_ENV_DEV', 'development');
define('APP_ENV_PROD', 'production');
define('APP_ENV', getenv('APP_ENV'));

require APP_ROOT_DIR.'/vendor/autoload.php';

$config = new \Zend\Config\Config(
    require APP_ROOT_DIR.'/config/production.php',
    true
);

if (APP_ENV === APP_ENV_DEV) {
    $config->merge(
        new \Zend\Config\Config(require APP_ROOT_DIR.'/config/development.php')
    );
}

$config = $config->toArray();

$app = new \Tick\Application();
$app['debug'] = $config['app.debug'];

$app->register(new \Silex\Provider\ServiceControllerServiceProvider());
$app->register(new \Silex\Provider\HttpFragmentServiceProvider());
$app->register(new \Saxulum\Console\Provider\ConsoleProvider());
$app->register(new \Silex\Provider\DoctrineServiceProvider(), $config['db.config']);
$app->register(new \Saxulum\DoctrineOrmManagerRegistry\Provider\DoctrineOrmManagerRegistryProvider());
$app->register(new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), $config['orm.config']);

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), [
    'security.firewalls' => [
        'profiler' => [
            'pattern' => '^/(_(profiler|wdt)|css|images|js)/',
            'security' => false,
        ],
        'site' => [
            'pattern' => '^/',
            'anonymous' => true
        ]
    ]
]);

$app->register(new \Silex\Provider\TwigServiceProvider(), $config['twig']);

$app->extend('twig', function (\Twig_Environment $twig) use ($app, $config) {
    foreach ($config['twig.folders'] as $twigfolder) {
        $app['twig.loader.filesystem']->addPath(
            $twigfolder[0],
            $twigfolder[1]
        );
    }

    return $twig;
});

$app->extend('twig', function (\Twig_Environment $twig) use ($app, $config) {
    $twig->addGlobal('layout', '@app/layout/layout.twig');

    return $twig;
});

$app->register(new \Silex\Provider\WebProfilerServiceProvider(), [
    'profiler.cache_dir' => APP_ROOT_DIR.'/var/cache/profiler',
    'profiler.mount_prefix' => '/_profiler',
]);
$app->register(new \Sorien\Provider\DoctrineProfilerServiceProvider());

$app->extend('doctrine', function (\Saxulum\DoctrineOrmManagerRegistry\Doctrine\ManagerRegistry $managerRegistry) {
    \Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

    return $managerRegistry;
});

$app['tick.service.randomGenerator'] = function () {
    return new \Tick\Service\RandomGenerator();
};

$app['tick.command.createDefaultUsers'] = function (\Tick\Application $app) {
    $command = new \Tick\ConsoleCommands\CreateDefaultUsers();
    $command->setRandomGenerator($app['tick.service.randomGenerator']);
    $command->setDbal($app['doctrine']->getConnection());
    $command->setPasswordEncoder($app['security.default_encoder']);
    $command->setEm($app['doctrine']->getManager());

    return $command;
};

$app->register(new Sorien\Provider\PimpleDumpProvider());

return $app;
