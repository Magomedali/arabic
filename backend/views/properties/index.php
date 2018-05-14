<?php

use yii\helpers\{Html,Url};
use yii\grid\GridView;;

$this->title = Yii::t('site', 'PROPERTIES');
?>
<div class="row">
	<div class="col-xs-12 page-action-panel">
		<?php
			if(\Yii::$app->user->can("superadmin")){
            	echo Html::a(Yii::t('properties','CREATE_NEW_PROPERTIES'),['/properties/create'],['class'=>'btn btn-primary']);
			}
		?>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<?php
			echo GridView::widget([
				'dataProvider'=>$dataProvider,
				'filterModel'=>$PropertiesSearch,
				'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
				'tableOptions' => [
	            	'id'=>'properties','class'=>'table table-striped table-bordered'
	        	],
				'summary'=>"",
				'columns'=>[
					'id',
					'name',
					'title',
					'critical_down_time',
					[
						'class'=>'yii\grid\ActionColumn',
						'template'=>"{create}",
						'buttons'=>[
							'create'=>function($url, $model, $key){

								if(\Yii::$app->user->can('superadmin')){
									return Html::a('<span class="glyphicon glyphicon-pencil"></span>',$url);
								}
								
							}
						]
					]
				]
			]);
		?>
	</div>
</div>