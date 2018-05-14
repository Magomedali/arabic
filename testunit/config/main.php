<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
	'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
    	// 'db' => [
     //        'class' => 'yii\db\Connection',
     //        'dsn' => 'sqlite:'.__DIR__.'/../data/test.db',
     //        'username' => '',
     //        'password' => '',
     //        'charset' => 'utf8',
     //    ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlsrv:Server=ALI;Database=bicyclepark_test',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ],
        'user' => [
            'class' => 'testunit\preloads\User',
            'identityClass' => 'common\models\User',
        ],
    ],
    'params' => $params,
];