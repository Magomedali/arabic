<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;

$this->title = Yii::t("site","LEVEL_FROM");

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
			<div class="col-xs-3">
				<?php echo $form->field($model,"desc")->textarea();?>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-3">
				<?php echo $form->field($model,"position")->textInput(['type'=>'number','min'=>1]);?>
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