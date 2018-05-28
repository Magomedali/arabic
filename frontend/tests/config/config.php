<?php
return [
    
	'language'=>'en-US',
    'components' => [
    	'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite:'.__DIR__.'/../../../testunit/data/test.db',
            
        ],
        'mailer'=>[
        	'userFileTransport' => true,
        ],
        'urlManager'=>[
        	'showScriptName' => true,
        ]
    ]
];