<?php 

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\widgets\datepicker\DatePicker;
use yii\helpers\Url;
use api\models\Request;

function tree($key,$node){
	$html = "";
	
	if(is_object($node) || is_array($node)){
		$html .="<li>".$key.": <ul class='sub_params'>";
		foreach ($node as $vvk => $vvv) {		
			//$html .="<li>".$vvk.": ".$vvv."</li>";
			$html .=tree($vvk,$vvv);
		}
		$html .="</ul></li>";
	}else{
		$html .="<li>".$key.": ".$node."</li>";
	}
		
	
	return $html;
}






	echo GridView::widget([
			'dataProvider'=>$dataProvider,
			'filterModel'=>$RequestSearch,
			'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
			'tableOptions' => [
            	'id'=>'requests','class'=>'table table-striped table-bordered requests'
        	],
        	'summary'=>'',
			'rowOptions'=>function($model){
			        		
			        if((int)$model->result && (int)$model->completed)
			            $class = "success";
			        elseif(!(int)$model->result && (int)$model->completed)
			            $class = "warning";
			        elseif(!(int)$model->result && !(int)$model->completed)
			            $class = "";

			            	
			        return ['class' => $class];
			  },
			'columns'=>[
				[
					'attribute'=>'id',
					'label'=>'Номер',
					'value'=>function ($a) {
                            return "#".$a->id;
                    },
                    'contentOptions'=>['class'=>'th_id'],
					'headerOptions'=>['class'=>'td_id']
				],
				[
					'attribute'=>'date_init',
					'contentOptions'=>['class'=>'date_td'],
					'value'=>function ($a) {
                            return $a->date_init;
                        },
					'format'=>'raw',
					'filter'=>"<div class='date-range'>".DatePicker::widget([
							'model'=>$RequestSearch,
							'language'=>'ru',
							'attribute'=>'date_from',
							'options' => ['placeholder' => 'c'],
							'pickerButton'=>false,
							'pluginOptions'=>[
								'autoclose'=>true,
        						'format' => 'dd.mm.yyyy'
    						]
						]) . "" . DatePicker::widget([
							'model'=>$RequestSearch,
							'language'=>'ru',
							'attribute'=>'date_to',
							'pickerButton'=>false,
							'lastWidgetInPage'=>true,
							'options' => ['placeholder' => 'по'],
							'pluginOptions'=>[
								'autoclose'=>true,
        						'format' => 'dd.mm.yyyy'
    						]
						])."</div>",
					'contentOptions'=>['class'=>'td_date_init'],
					'headerOptions'=>['class'=>'th_date_init']
				],
				[
					'attribute'=>'date_executed',
					'label'=>'Дата выполнения',
					'value'=> function($a){
						return $a->date_executed;
					}
				],
				
				
				
				// [
				// 	'attribute'=>'type',
				// 	'label'=>'Тип запроса',
				// 	'value'=> function(Request $a){
				// 		return $a->type;
				// 	}
				// ],
				[
					'attribute'=>'request_type',
					'label'=>'Запрос',
					'value'=> function($a){
						if(array_key_exists($a->request_type,Request::$type_requests))
							return Request::$type_requests[$a->request];
						else 
							return $a->request_type;
						
					},
					'format'=>'raw',
					'filter'=>Html::activeDropDownList($RequestSearch,'request_type',Request::$type_requests,['class'=>'form-control','prompt'=>'Вид запроса']),
					'contentOptions'=>['class'=>'td_request'],
					'headerOptions'=>['class'=>'th_request']
				],

				[
					'attribute'=>'result',
					'label'=>'Результат',
					'value'=> function($a){
						return (int)$a->result ? "Успешно" : "Ошибка";
					},
					'format'=>'raw',
					'filter'=>Html::activeDropDownList($RequestSearch,'result',[0=>'Ошибка',1=>'Успешно'],['class'=>'form-control','prompt'=>'Результат']),
					'contentOptions'=>['class'=>'td_result'],
					'headerOptions'=>['class'=>'th_result']
				],

				[
					'attribute'=>'completed',
					'label'=>'Статус выполнения',
					'value'=> function($a){
						return (int)$a->completed ? "Выполнен" : "Не выполнен";
					},
					'format'=>'raw',
					'filter'=>Html::activeDropDownList(
						$RequestSearch,'completed',
						[0=>'Не выполнен',1=>'Выполнен'],
						['class'=>'form-control','prompt'=>'Статус выполнения']
					),
					'contentOptions'=>['class'=>'td_completed'],
					'headerOptions'=>['class'=>'th_completed']
				],

				[
					'attribute'=>'params_in',
					'label'=>'Входные параметры',
					'value'=> function($a){
						$params = json_decode($a->params_in);
						$html = "<ul class='params_collapse'>";
						$collapse = "";
							if(is_object($params)){
								$l = 0;
								foreach ($params as $key => $value) {
									if($l === 0){
										$html .="<li><ul id='paramsin{$a->id}' class='collapse'>";
									}
									$l++;
									if(!is_object($value) && !is_array($value)){
										$html .="<li>".$key.": ".$value."</li>";
									}else{
										$html .="<li>".$key.": <ul class='sub_params'>";
											foreach ($value as $vkey => $vv) {
												$html .=tree($vkey,$vv);
											}
										$html .="</ul></li>";
									}
									
								}

								if($l > 0){
									$html .="</ul></li>";
									$collapse = "<a href='#paramsin{$a->id}' data-toggle='collapse'>Все</a>";
								}
							}
						$html .= "</ul>";
						return $collapse.$html;
					},
					'format'=>'raw',
					'contentOptions'=>['class'=>'td_params_in'],
					'headerOptions'=>['class'=>'th_params_in']
				],
				[
					'attribute'=>'params_out',
					'label'=>'Выходные параметры',
					'value'=> function($a){
						$params = json_decode($a->params_out);
						$html = "<ul class='params_collapse'>";
						$collapse = "";
							if(is_object($params)){
								$l = 0;
								foreach ($params as $key => $value) {
									if($l === 0){
										$html .="<li><ul id='paramsount{$a->id}' class='collapse'>";
									}
									$l++;
									if(!is_object($value) && !is_array($value)){
										$html .="<li>".$key.": ".$value."</li>";
									}else{
										$html .="<li>".$key.": <ul class='sub_params'>";
											foreach ($value as $vkey => $vv) {
												$html .=tree($vkey,$vv);
											}
										$html .="</ul></li>";
									}
								}

								if($l > 0){
									$html .="</ul></li>";
									$collapse = "<a href='#paramsount{$a->id}' data-toggle='collapse'>Все</a>";
								}
							}
						$html .= "</ul>";
						return $collapse.$html;
					},
					'format'=>'raw',
					'contentOptions'=>['class'=>'td_params_out'],
					'headerOptions'=>['class'=>'th_params_out']
				],
				
				
			
			],
		])?>