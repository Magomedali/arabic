<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;
use backend\models\Element;

if(is_array($block_elements) && count($block_elements)){
	foreach ($block_elements as $key => $ble) {
		
?>
<div class="row block-element">	

	<?php $form = ActiveForm::begin(['action'=>Url::to(['lesson/add-element']),'options' =>['enctype'=>'multipart/form-data']]); ?>
	<div class="col-xs-6">	
		<?php
			

			if($ble['type'] == Element::TYPE_VIDEO){
			
				echo $form->field($ble,'content')->textarea();
			
				echo $form->field($ble,"files")->fileInput();
			
			}elseif($ble['type'] == Element::TYPE_AUDIO){
			
				echo $form->field($ble,'content')->textarea();
			
				echo $form->field($ble,"files")->fileInput();
				
				if($ble['file_name']){

				?>
					
					<div>
						<audio controls>
							<source src="<?php echo $ble->file?>">
							Ваш браузер не пожжерживает тег audio!
						</audio>
					</div>
				<?php
				}

			}elseif($ble['type'] == Element::TYPE_IMAGE){
			
				echo $form->field($ble,'content')->textarea();
			
				echo $form->field($ble,"files")->fileInput();
				
				if($ble['file_name']){
				
				?>
					
					<div>
						<img src="<?php echo $ble->file?>">
					</div>
				<?php
				}

			}else{
			
				echo $form->field($ble,'content')->textarea();
			
			}

		?>
	</div>

	<div class="col-xs-2">
		<?php echo isset($ble['id']) ?  $form->field($ble,'id')->hiddenInput()->label(false) : "";?>
		<?php echo $form->field($ble,'block')->hiddenInput(['value'=>$block])->label(false); ?>
		<?php echo $form->field($ble,'position')->textInput(['min'=>1,'type'=>'number']); ?>
	</div>

	<div class="col-xs-2">
		<?php 
			echo Html::submitInput("SAVE",['class'=>'btn btn-success']);
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
	<?php ActiveForm::end();?>
</div>
<?php 
		}
	}
?>