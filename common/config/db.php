<?php
return [
    'components' => [
        // 'db' => [
        //     'class' => 'yii\db\Connection',
        //     'dsn' => 'mysql:host=localhost;dbname=parking_system',
        //     'username' => 'root',
        //     'password' => '',
        //     'charset' => 'utf8',
        // ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlsrv:Server=ALI;Database=bicyclepark',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ],
    ]
];