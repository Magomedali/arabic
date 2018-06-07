<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use vova07\imperavi\Widget;

$this->title = Yii::t('level',"LEVEL_TITLE",['title'=>$model->title]);
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('level',"LEVELS"),
	'url' => Url::to(['level/index'])
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="col-xs-12 page-action-panel">
		<?php
			if(\Yii::$app->user->can("superadmin")){
            	echo Html::a(Yii::t('level','TO_UPDATE'),['/level/form','id'=>$model->id],['class'=>'btn btn-primary']);
			}
			if(\Yii::$app->user->can("superadmin")){
            	echo Html::a(Yii::t('level','TO_DELETE'),['/level/delete','id'=>$model->id],['class'=>'btn btn-danger','data-confirm'=>Yii::t('level','confirm_delete')]);
			}
		?>
	</div>
</div>


<div class="row">
	<div class="col-xs-3">
		<h4><?php echo Yii::t('level','LEVEL');?></h4>
		<table class="table table-bordered table-collapsed table-hover">
			<tr>
				<td><?php echo $model->getAttributeLabel("title");?></td><td><?php echo Html::encode($model->title);?></td>
			</tr>
			<tr>
				<td><?php echo $model->getAttributeLabel("position");?></td><td><?php echo Html::encode($model->position);?></td>
			</tr>
		</table>
	</div>
	<div class="col-xs-9">
		<?php echo $model->desc;?>
	</div>
</div>


<div class="row">
	<div class="col-xs-12">
		 <h3><?php echo Yii::t('level','FROM_NEW_LESSON');?></h3>
	</div>
	<div class="col-xs-12">
		<?php $form = ActiveForm::begin(['id'=>'newLesson']);?>
		<div class="row">
			<div class="col-xs-3">
				<?php echo $form->field($lesson,"title")->textInput()?>
			</div>
			<div class="col-xs-3">
				<?php echo $form->field($lesson,"number")->textInput(['type'=>'number','min'=>1])?>
			</div>
			<div class="col-xs-1">
				<?php echo $form->field($lesson,'isPublic')->checkbox();?>
			</div>
			<div class="col-xs-3">
				<?php echo $form->field($lesson,"level")->hiddenInput(['value'=>$model->id])->label(false)?>
				<?php echo Html::submitButton(Yii::t('level','ADD_LESSON'),['class'=>'btn btn-success'])?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<?php echo $form->field($lesson,'desc')->widget(Widget::className(), [
						'model'=>$lesson,
						'attribute'=>'desc',
						
					    'settings' => [
					        'lang' => 'ru',
					        'minHeight' => 200,
					        'imageUpload' => Url::to(['/lesson/image-upload']),
        					'imageManagerJson' => Url::to(['/lesson/images-get']),
        					'fileUpload' => Url::to(['/lesson/file-upload']),
        					'fileManagerJson' => Url::to(['/lesson/files-get']),
        					'imageDelete' => Url::to(['/lesson/file-delete']),
					        'plugins' => [
					        	'imagemanager',// => 'vova07\imperavi\bundles\ImageManagerAsset',
					        	'filemanager',// => 'vova07\imperavi\bundles\FileManagerAsset',
					            'fullscreen',
					            'fontsize',
					            'table',
					            'textdirection',
					            'textexpander',
					            'video',
					            'fontcolor',
					            'counter'
					        ]
					    ]
					]);?>
			</div>
		</div>
		<?php ActiveForm::end();?>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<?php 
			echo GridView::widget([
				'dataProvider'=>$dataProvider,
				'filterModel'=>$filterLessons,
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
					'title',
					'number',
					'isPublic',
					[
		                'class' => 'yii\grid\ActionColumn',
		                'template' => '{view}&nbsp&nbsp{form}&nbsp&nbsp{delete}',
		                'buttons' => [
		                    'view' => function ($url, $model, $key) {
		                        
		                        if (!Yii::$app->user->can('superadmin')) {
		                            return '';
		                        }
		                        $options = [

		                        ];
		                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['lesson/view','id'=>$model['id']] , $options);
		                    },
		                    'form' => function ($url, $model, $key) {
		                        
		                        if (!Yii::$app->user->can('superadmin')) {
		                            return '';
		                        }
		                        
		                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['lesson/form','id'=>$model['id']]);
		                    },
		                    'delete' => function ($url, $model, $key) {
		                        
		                        if (!Yii::$app->user->can('superadmin')) {
		                            return '';
		                        }
		                        
		                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['lesson/delete','id'=>$model['id']],['data-confirm'=>Yii::t("level",'LESSON_DELETE_CONFIRM')]);
		                    },
		                ]
	                ]
					
				],
			]);
		?>
	</div>
</div>