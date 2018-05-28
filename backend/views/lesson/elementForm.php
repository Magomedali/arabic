<?php
use yii\helpers\{Html,Url};
use yii\helpers\ArrayHelper;
use backend\models\Element;
use yii\bootstrap\ActiveForm;


$model = new Element;
?>

<div class="row block-element">	

	<?php $form = ActiveForm::begin(['action'=>Url::to(['lesson/add-element']),'options' =>['enctype'=>'multipart/form-data']]); ?>
	<div class="col-xs-6">	
		<?php
			if($type != Element::TYPE_TEXT){
				echo Html::tag("p",Element::$TYPE_TITLES[$type]);
				echo $form->field($model,'content')->textarea();
				echo $form->field($model,"files")->fileInput();
			}else{
				echo $form->field($model,'content')->textarea();
			}
		?>
	</div>

	<div class="col-xs-2">
		<?php echo $form->field($model,'position')->textarea(['min'=>1,'type'=>'number']);?>
	</div>
	
	<div class="col-xs-2">
		<?php 
			echo Html::submitInput("SAVE",['class'=>'btn btn-success']);
		?>
	</div>

	<div class="col-xs-2">
		<?php echo $form->field($model,'type')->hiddenInput(['value'=>$type])->label(false);?>
		<?php echo $form->field($model,'block')->hiddenInput(['value'=>$block])->label(false);?>

		<?php echo Html::a("X",null,['class'=>'btn btn-danger removeElement','data-confirm'=>Yii::t('lesson','REMOVE_ELEMENT_CONFIRM')]);?>
	</div>
	
	<?php ActiveForm::end();?>

</div>

