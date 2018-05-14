<?php

return [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['info'],
                'logFile'=>'@api/logs/info_Log.txt',
                'logVars'=>[],
                'categories'=>['api'],
            ],
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['info'],
                'logFile'=>'@api/logs/sessions_Log.txt',
                'logVars'=>[],
                'categories'=>['api_sessions'],
            ],
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['info'],
                'logFile'=>'@api/logs/states_Log.txt',
                'logVars'=>[],
                'categories'=>['api_states'],
            ],
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['info'],
                'logFile'=>'@api/logs/test_Log.txt',
                'logVars'=>[],
                'categories'=>['api_tests'],
            ]
        ];
    

?>