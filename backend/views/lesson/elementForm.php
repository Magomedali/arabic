<?php
use yii\helpers\{Html,Url};
use yii\helpers\ArrayHelper;
use backend\models\Element;
use yii\bootstrap\ActiveForm;


$model = new Element;
?>

<div class="media well block-element">	

	<?php $form = ActiveForm::begin(['action'=>Url::to(['lesson/add-element']),'options' =>['enctype'=>'multipart/form-data']]); ?>
		
		<div class="media-left">
			<?php
				echo Html::tag("p",Yii::t("lesson",Element::$TYPE_TITLES[$type]));
			?>
		</div>

		<div class="media-body">
			<div class="row">
				<div class="col-xs-1">
					<?php echo $form->field($model,'position')->textInput(['min'=>1,'type'=>'number','style'=>"width:80px"]);?>
				</div>

				<div class="col-xs-6">	
					<?php echo $form->field($model,'content')->textarea();?>
				</div>

				<?php
					if($type != Element::TYPE_TEXT){
				?>
					<div class="col-xs-3">
						<?php echo $form->field($model,"files")->fileInput();?>
					</div>
				<?php
					}
				?>
				<div class="col-xs-2 <?php echo $type != Element::TYPE_TEXT ? "" : "col-xs-offset-3" ; ?>">
					<div class="btn-group">
					<?php echo Html::submitInput("SAVE",['class'=>'btn btn-success']);?>
					<?php echo Html::a("X",null,['class'=>'btn btn-danger removeElement','data-confirm'=>Yii::t('lesson','REMOVE_ELEMENT_CONFIRM')]);?>
					</div>
				</div>
			<?php echo $form->field($model,'type')->hiddenInput(['value'=>$type])->label(false);?>
			<?php echo $form->field($model,'block')->hiddenInput(['value'=>$block])->label(false);?>
			</div>
		</div>
	<?php ActiveForm::end();?>

</div>

