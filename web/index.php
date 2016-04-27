<?php

defined('APPLICATION_DIR') || define('APPLICATION_DIR', __DIR__ . '/..');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../base/helpers/helpers.php');

load_environment();

defined('YII_DEBUG') || define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') || define('YII_ENV', env('YII_ENV'));

require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();