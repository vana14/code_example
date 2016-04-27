<?php

return [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'rules' => [
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        [
            'class' => 'fproject\rest\UrlRule',
            'controller' => [
                'test/articles',
            ],
        ],
    ],
];

