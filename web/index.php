<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// Composer autoload
require dirname(__DIR__) . DS . 'vendor' . DS . 'autoload.php';

// Symfony Dotenv load
try {
    $dotenv = new \Symfony\Component\Dotenv\Dotenv();
    $dotenv->load(dirname(__DIR__) . DS . '.env');
} catch (\Exception $e) {

}

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG', true));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV', 'dev'));

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
