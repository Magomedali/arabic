<?php


namespace common\widgets\googlemap;

use yii\web\AssetBundle;


class GoogleMapAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/googlemap/assets';
    
    public $css = [];

    public $js = [];

    public $depends = ['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset'];
}
