<?php
/** @var \Silex\Application $app */
$app = require dirname(__DIR__) . '/src/app.php';
require APP_ROOT_DIR . '/src/controllers.php';
$app->run();