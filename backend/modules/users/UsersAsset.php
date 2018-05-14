<?php

namespace backend\modules\users;

use yii\web\AssetBundle;

/**
 * Widget asset bundle
 */
class UsersAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@backend/modules/users/assets';


	public $css = [
        'css/users.css'
    ];


    public $js = [
        'js/users.js'
    ];

    /**
	 * @inheritdoc
	 */
	public $depends = [
		'yii\web\JqueryAsset'
	];

}
