<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;

$this->title = Yii::t("level","LEVEL_FROM");

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
	<div class="col-xs-12">
		<?php 
			$form = ActiveForm::begin(['id'=>'levelForm']);
		?>

		<div class="row">
			<div class="col-xs-3">
				<?php echo $form->field($model,"title")->textInput();?>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<?php echo $form->field($model,'desc')->widget(Widget::className(), [
						'model'=>$model,
						'attribute'=>'desc',
						
					    'settings' => [
					        'lang' => 'ru',
					        'minHeight' => 200,
					        'imageUpload' => Url::to(['/level/image-upload']),
        					'imageManagerJson' => Url::to(['/level/images-get']),
        					'fileUpload' => Url::to(['/level/file-upload']),
        					'fileManagerJson' => Url::to(['/level/files-get']),
        					'imageDelete' => Url::to(['/level/file-delete']),
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

		<div class="row">
			<div class="col-xs-3">
				<?php echo $form->field($model,"position")->textInput(['type'=>'number','min'=>1]);?>
			</div>
			<div class="col-xs-2">
				<?php echo $form->field($model,'showDesc')->checkbox();?>
			</div>
			<div class="col-xs-3">
				<?php echo $form->field($model,'isPublic')->checkbox();?>
			</div>
		</div>


		<div class="row">
			<div class="col-xs-3">
				<?php echo Html::submitButton(Yii::t("site","SAVE"),['class'=>'btn btn-primary']);?>
			</div>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>