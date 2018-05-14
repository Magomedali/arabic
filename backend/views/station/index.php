<?php

use yii\helpers\{Html,Url};
use backend\widgets\monitoring\Monitoring;

$this->title = Yii::t("station","STATIONS");
?>

<div class="row">
	<div class="col-xs-12 page-action-panel">
		<?php
			if(\Yii::$app->user->can("superadmin")){
            	echo Html::a(Yii::t('station','CREATE_NEW_STATION'),['/station/create'],['class'=>'btn btn-primary']);
			}
		?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<?php echo Monitoring::widget([
				'options'=>[
						'urlUpdate'=>Url::to(['station/monitoring']),
						'pageUrl'=>Url::to(['station/index']),
						'gridView' => $view,
				]
		]);?>
	</div>
</div>