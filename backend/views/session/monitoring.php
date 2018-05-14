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
			'filterModel'=>$SessionSearch,
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
				[
					'attribute'=>'client_id',
					"value"=>function($s){
						return $s->client->fullname;
					}
				],
				[
					'attribute'=>'stand_id',
					'label'=>"Станция",
					"value"=>function($s){
						return $s->station->code;
					}
				],
				[
					'attribute'=>'stand_id',
					//'label'=>"Стойка",
					"value"=>function($s){
						return $s->stand->number;
					}
				],
				[
					'attribute'=>'start_time',
					//'label'=>"Стойка",
					"value"=>function($s){
						return date("d.m.Y H:i:s",strtotime($s->start_time));
					}
				],
				[
					'attribute'=>'finish_time',
					//'label'=>"Стойка",
					"value"=>function($s){
						return $s->finish_time ? date("d.m.Y H:i:s",strtotime($s->finish_time)) : "";
					}
				],
				[
					'attribute'=>'accepted',
					//'label'=>"Стойка",
					"value"=>function($s){
						return $s->accepted;
					}
				],
				[
					'attribute'=>'actual',
					//'label'=>"Стойка",
					"value"=>function($s){
						return $s->actual;
					}
				],
				[
	                'class' => 'yii\grid\ActionColumn',
	                'template' => '{accept}{send}',
	                'buttons' => [
	                    'accept' => function($url, $model, $key){
	                        
	                        if (!Yii::$app->user->can('superadmin') || $model->accepted) {
	                            return '';
	                        }

	                        $options = [
	                        	'title'=>'accept'
	                        ];

	                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
	                    },

	                    'send' => function($url, $model, $key){
	                        
	                        if (!Yii::$app->user->can('superadmin') || $model->accepted) {
	                            return '';
	                        }

	                        return Html::a('<span class="glyphicon glyphicon-send"></span>', $url);
	                    },
	                ]
                ]
			],
		]);
?>

