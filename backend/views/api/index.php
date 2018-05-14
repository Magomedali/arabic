<?php 

use yii\helpers\{Html,ArrayHelper,Url};
use backend\widgets\monitoring\Monitoring;

$this->title = 'Api requests';

?>


<div class="row">
	<div class="col-xs-12">
		<?php echo Monitoring::widget([
				'options'=>[
						'urlUpdate'=>Url::to(['api/monitoring']),
						'pageUrl'=>Url::to(['api/index']),
						'gridView' => $view,
				]
		]);?>
	</div>
</div>
