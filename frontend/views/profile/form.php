<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('site',"CHANGE_PROFILE");
?>

<div class="row">
	<div class="col-xs-12">
		<h3><?php echo $this->title;?></h3>
	</div>
</div>

<div class="row">
	<div class="col-xs-4">
		<?php $form = ActiveForm::begin(['id'=>"user_update"]);?>
			
			<?php echo $form->field($model,"sname")->textInput();?>

			<?php echo $form->field($model,"name")->textInput();?>
			
			<?php echo $form->field($model,"patronymic")->textInput();?>

			<?php echo $form->field($model, 'bdate')->input("date") ?>

			<div class="form-group">
                    <?php echo Html::submitButton(Yii::t('site',"BTN_SAVE"), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

		<?php ActiveForm::end();?>
	</div>
</div>