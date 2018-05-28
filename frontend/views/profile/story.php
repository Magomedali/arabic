<?php

use yii\grid\GridView;
use yii\helpers\{Html,Url};


$this->title = Yii::t('profile',"SESSION_STORY");



$this->params['breadcrumbs'][]= ['label'=>Yii::t('profile',"PERSONAL_PAGE"),'url'=>Url::to(['profile/index'])];
$this->params['breadcrumbs'][]= $this->title;

?>

<div class="row">
	<div class="col-xs-12">
		<h2><?php echo $this->title;?></h2>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<?php
			echo GridView::widget([
				'dataProvider'=>$dataProvider,
				'filterModel'=>$report,
				'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
				'tableOptions' => [
	            	'id'=>'transactions','class'=>'table table-striped table-bordered'
	        	],
	        	'summary'=>'',
				'columns'=>[
					'id',
					[
						'attribute'=>"start_time",
						"value"=>function($m){
							return date("d.m.Y",strtotime($m->start_time));
						}
					],
					[
						'attribute'=>"finish_time",
						"value"=>function($m){
							return $m->finish_time ? date("d.m.Y",strtotime($m->finish_time)) : "";
						}
					],
					[
						'attribute'=>"station",
						"value"=>function($m){
							return $m->station->code;
						}
					],
					[
						'attribute'=>"stand_id",
						"value"=>function($m){
							return $m->stand->number;
						}
					],
					[
						'attribute'=>"actual",
						"value"=>function($m){
							return $m->actual ? "+" : "-";
						}
					],
					[
						'attribute'=>"accepted",
						"value"=>function($m){
							return $m->accepted ? "+" : "-";
						}
					]
				]
			]);
		?>
	</div>
</div>