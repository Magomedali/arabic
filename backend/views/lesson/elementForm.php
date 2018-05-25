<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\Element;


$class = "Elements[{$count}]";


?>

<div class="row block-element">	

	<div class="col-xs-8">	
		<?php
			if($type == Element::TYPE_IMAGE){
				echo Html::textarea($class."[content]",null,['class'=>'form-control']);
			}elseif($type == Element::TYPE_VIDEO){
				echo Html::textarea($class."[content]",null,['class'=>'form-control']);
			}elseif($type == Element::TYPE_IMAGE){
				echo Html::textarea($class."[content]",null,['class'=>'form-control']);
			}else{
				echo Html::textarea($class."[content]",null,['class'=>'form-control']);
			}
		?>
	</div>

	<div class="col-xs-2">
		<?php echo Html::textInput($class."[position]",null,['class'=>'form-control','min'=>1,'type'=>'number']);?>
	</div>

	<div class="col-xs-2">
		<?php echo Html::hiddenInput($class."[type]",$type);?>
		<?php echo Html::a("X",null,['class'=>'btn btn-danger removeElement','data-confirm'=>Yii::t('lesson','REMOVE_ELEMENT_CONFIRM')]);?>
	</div>

</div>

