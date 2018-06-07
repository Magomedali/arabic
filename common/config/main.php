<?php

$smtp = require_once(__DIR__."/smtp.php");

return [
    'language' => 'ru-RU',
    //'language' => 'en',
    //'sourceLanguage' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'i18n'=>[
            'translations'=>[
                '*'=>[
                    'class'=>'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                ],
            ]
            
        ],
        'security'=>[
            'class'=>"common\helpers\Security"
        ],
        'authClientCollection'=>[
            'class'=>'yii\authclient\Collection',
            'clients'=>[
                
            ]
        ],
        'authManager' => [
            'class' => 'common\helpers\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => $smtp['host'],  // e.g. smtp.mandrillapp.com or smtp.gmail.com
            //     'username' => $smtp['username'],
            //     'password' => $smtp['password'],
            //     'port' => $smtp['port'], // Port 25 is a very common port too
            //     'encryption' => $smtp['encryption'], // It is often used, check your provider or mail server specs
            // ],
        ],
        'assetManager'=>[
            'bundles'=>[
                'dosamigos\google\maps\MapAsset'=>[
                    'options'=>[
                        'key'=>'AIzaSyDB4ObYUSmHECFac5UMv7tAxBwVaPCIPcw',
                        'libraries'=>'places'
                    ]
                ]
            ]
        ]
    ],
];
