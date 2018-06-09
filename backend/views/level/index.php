<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->title = Yii::t("site","LEVELS");

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="col-xs-12">
		<?php echo Html::a(Yii::t("level","ADD_NEW"),['level/form'],['class'=>'btn btn-success'])?>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<?php 
			echo GridView::widget([
				'dataProvider'=>$dataProvider,
				'filterModel'=>$filterModel,
				'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
				'tableOptions' => [
	            	'id'=>'transactions','class'=>'table table-striped table-bordered'
	        	],
	        	'summary'=>'',
				'columns'=>[
					[
						'attribute'=>'id',
						'label'=>'ID',
						'value'=>function ($l) {
	                            return "#".$l['id'];
	                        }
					],
					'position',
					'title',
					'isPublic',
					'showDesc',
					[
		                'class' => 'yii\grid\ActionColumn',
		                'template' => '{view}&nbsp&nbsp{form}',
		                'buttons' => [
		                    'view' => function ($url, $model, $key) {
		                        
		                        if (!Yii::$app->user->can('superadmin')) {
		                            return '';
		                        }
		                        $options = [
		                        ];
		                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
		                    },
		                    'form' => function ($url, $model, $key) {
		                        
		                        if (!Yii::$app->user->can('superadmin')) {
		                            return '';
		                        }
		                        
		                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
		                    },
		                ]
	                ]
					
				],
			]);
		?>
	</div>
</div>