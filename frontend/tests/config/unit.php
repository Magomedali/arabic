<?php

return  yii\helpers\ArrayHelper::merge(
	require __DIR__ . '/../../../common/config/test.php',
	require __DIR__ . '/config.php'
);