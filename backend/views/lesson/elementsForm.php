<?php

use yii\helpers\Html;
use backend\models\Element;

if(is_array($block_elements) && count($block_elements)){
	foreach ($block_elements as $key => $ble) {
		$n = $count+$key+1;
		$class = "Elements[{$n}]";
?>
<div class="row block-element">	

	<div class="col-xs-8">	
		<?php

			if($ble['type'] == Element::TYPE_IMAGE){
				echo Html::textarea($class."[content]",$ble['content'],['class'=>'form-control']);
			}elseif($ble['type'] == Element::TYPE_VIDEO){
				echo Html::textarea($class."[content]",$ble['content'],['class'=>'form-control']);
			}elseif($ble['type'] == Element::TYPE_IMAGE){
				echo Html::textarea($class."[content]",$ble['content'],['class'=>'form-control']);
			}else{
				echo Html::textarea($class."[content]",$ble['content'],['class'=>'form-control']);
			}

		?>
	</div>

	<div class="col-xs-2">
		<?php echo isset($ble['id']) ?  Html::hiddenInput($class."[id]",$ble['id']) : "";?>

		<?php echo Html::textInput($class."[position]",$ble['position'],['class'=>'form-control','min'=>1,'type'=>'number']);
		?>
	</div>

	<div class="col-xs-2">
		<?php 
			$class_remove = isset($ble['id']) ? "removeElementFromDb" : "removeElement";
			$url = isset($ble['id']) ? ['lesson/remove-element','id'=>$ble['id']] : null;
			$opts = ['class'=>"btn btn-danger {$class_remove}"];
			if(!$url){
				$opts['data-confirm'] = Yii::t('lesson','REMOVE_ELEMENT_CONFIRM');
			}

			echo Html::a("X",$url,$opts);
		?>
	</div>
</div>
<?php 
		}
	}
?>