<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('properties', 'CREATE_NEW');
?>
<div class="row">
	<div class="col-xs-4">
		<?php $form = ActiveForm::begin(['id'=>'form_property']); ?>

		<?php echo  $form->field($model,'name')->textInput(); ?>

		<?php echo  $form->field($model,'title')->textInput(); ?>

		<?php echo  $form->field($model,'critical_down_time')->textInput(); ?>

		<?php echo  Html::submitButton(Yii::t('site',"BTN_SAVE"),['class'=>'btn btn-primary']); ?>

		<?php ActiveForm::end(); ?>
	</div>
</div>