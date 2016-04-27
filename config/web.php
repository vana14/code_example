<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'components' => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'CFALEVJeNiB_sSX8S5Ui6iOsS4EVJVKo',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n'         => [
            'translations' => [
                'event_manager' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath'       => '@app/messages'
                ],
            ],
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => require(__DIR__ . '/db.php'),
        'urlManager'   => require(__DIR__ . '/url_manager.php'),
    ],
    'modules'    => [
        'test' => [
            'class' => 'app\modules\test\Module',
        ],
    ],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
