<?php

use yii\helpers\{Html,Url};
use backend\widgets\monitoring\Monitoring;

$this->title = Yii::t("site","SESSIONS");
?>

<div class="row">
	<div class="col-xs-12 page-action-panel">
		
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<?php echo Monitoring::widget([
				'options'=>[
						'urlUpdate'=>Url::to(['session/monitoring']),
						'pageUrl'=>Url::to(['session/index']),
						'gridView' => $view,
				]
		]);?>
	</div>
</div>