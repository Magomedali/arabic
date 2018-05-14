<?php

$log_targets = require __DIR__ . '/log_config.php';

return [
    'id' => 'bicyclepark-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'modules' => [],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
         'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'api\helpers\PrettyJsonResponseFormatter',
                    'prettyPrint' => true,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession'=>false
        ],
        'log' => [
            'traceLevel'=> YII_DEBUG ? 3 : 0,
            'targets' => $log_targets,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => ['requests']],
                'requests'=>'requests/index',
                'requests/complete'=>'requests/complete',
            ],
        ],
    ],
    'params' =>[],
];
