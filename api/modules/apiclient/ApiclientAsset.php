<?php

namespace api\modules\apiclient;

use yii\web\AssetBundle;

/**
 * Widget asset bundle
 */
class ApiClientAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@api/modules/apiclient/assets';


	public $css = [
        'css/apiclient.css'
    ];


    public $js = [
        'js/apiclient.js'
    ];

    /**
	 * @inheritdoc
	 */
	public $depends = [
		'yii\web\JqueryAsset'
	];

}
