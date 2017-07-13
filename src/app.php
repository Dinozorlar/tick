<?php

define('APP_ROOT_DIR', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
define('APP_ENV_DEV', 'development');
define('APP_ENV_PROD', 'production');
define('APP_ENV', getenv('APP_ENV') ?: 'development');

require APP_ROOT_DIR . '/vendor/autoload.php';

$config = new \Zend\Config\Config(
    require APP_ROOT_DIR . '/config/production.php',
    true
);

if (APP_ENV === APP_ENV_DEV) {
    $config->merge(
        new \Zend\Config\Config(require APP_ROOT_DIR . '/config/development.php')
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
$app->extend('doctrine', function (\Saxulum\DoctrineOrmManagerRegistry\Doctrine\ManagerRegistry $managerRegistry) {
    \Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

    return $managerRegistry;
});
$app->register(new Silex\Provider\SessionServiceProvider());


$app->register(new Silex\Provider\SecurityServiceProvider(), [
    'security.firewalls' => [
        'profiler' => [
            'pattern' => '^/(_(profiler|wdt)|css|images|js)/',
            'security' => false,
        ],
        'login_path' => [
            'pattern' => '^/login$',
            'security' => false
        ],
        'site' => [
            'pattern' => '^/',
            'anonymous' => false,
            'http' => true,
            'security' => true,
            'remember_me' => [
                'key' => 'AAOL9QABCxnW998B9R4e5MQwHoid7b9gp8x789LElgPcwj88Cl',
                'always_remember_me' => true,
                'httponly' => true,
                'remember_me_parameter' => 'rememberMe'
            ],
            'form' => [
                'login_path' => '/login',
                'check_path' => '/check_login',
                'username_parameter' => 'username',
                'password_parameter' => 'password'
            ],
            'users' => function () use ($app) {
                return $app['tick.user.provider'];
            }
        ],

    ]
]);

$app->register(new \Silex\Provider\RememberMeServiceProvider());

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
    'profiler.cache_dir' => APP_ROOT_DIR . '/var/cache/profiler',
    'profiler.mount_prefix' => '/_profiler',
]);
$app->register(new \Sorien\Provider\DoctrineProfilerServiceProvider());


$app['tick.service.randomGenerator'] = function () {
    return new \Tick\Service\RandomGenerator();
};

$app['tick.user.provider'] = function () use ($app) {
    $usp = new \Tick\Service\UserSecurityProvider();
    $usp->setEm($app['orm.em']);
    return $usp;
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


$app->match('/login', function () use ($app) {
    $data = [];


    $data['error_message'] = $app['security.last_error']($app['request_stack']->getCurrentRequest());
    return $app['twig']->render('login.twig', $data);
});


return $app;
