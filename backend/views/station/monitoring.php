<?php 

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

// use common\widgets\datepicker\DatePicker;



$layout = <<< HTML
    {input1}<br>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;

	echo GridView::widget([
			'dataProvider'=>$dataProvider,
			'filterModel'=>$StationSearch,
			'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
			'tableOptions' => [
            	'id'=>'transactions','class'=>'table table-striped table-bordered'
        	],
        	'summary'=>'',
			'columns'=>[
				[
					'attribute'=>'id',
					'label'=>'ID',
					'value'=>function ($s) {
                            return "#".$s->id;
                        }
				],
				'code',
				'latitude',
				'longitude',
				'ip',
				[
	                'class' => 'yii\grid\ActionColumn',
	                'template' => '{view}&nbsp&nbsp{create}',
	                'buttons' => [
	                    'view' => function ($url, $model, $key) {
	                        if (!Yii::$app->user->can('superadmin')) {
	                            return '';
	                        }
	                        $options = [
	                        ];
	                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
	                    },
	                    'create' => function ($url, $model, $key) {
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

