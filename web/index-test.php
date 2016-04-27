<?php

defined('APPLICATION_DIR') || define('APPLICATION_DIR', __DIR__ . '/..');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../helpers/helpers.php');

load_environment('test');

// NOTE: Make sure this file is not accessible when deployed to production
if (!env('TESTS_IGNORE_REMOTE') && !in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'test');

require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../tests/codeception/config/api.php');

require(__DIR__ . '/../vendor/codeception/c3/c3.php');

if (array_key_exists('HTTP_IGNOREAUTHENTICATION', $_SERVER)) {
    defined('API_IGNORE_AUTH') || define('API_IGNORE_AUTH', true);
}

(new yii\web\Application($config))->run();