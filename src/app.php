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

$app->register(new \Silex\Provider\ServiceControllerServiceProvider());
$app->register(new \Silex\Provider\HttpFragmentServiceProvider());
$app->register(new \Silex\Provider\WebProfilerServiceProvider(), [
    'profiler.cache_dir' => APP_ROOT_DIR.'/var/cache/profiler',
    'profiler.mount_prefix' => '/_profiler',
]);

$app->register(new \Silex\Provider\DoctrineServiceProvider(), $config['db.config']);

$app->register(new \Saxulum\DoctrineOrmManagerRegistry\Provider\DoctrineOrmManagerRegistryProvider());

return $app;
