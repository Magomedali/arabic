<?php

use yii\helpers\{Html,Url};
use yii\helpers\ArrayHelper;
use backend\models\Element;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use yii\widgets\InputWidget;


$errors = $element && $element->hasErrors() ? $element->getErrors() : null;

?>

<div class="media well block-element">	

	<?php //$form = ActiveForm::begin(['action'=>Url::to(['lesson/add-element']),'options' =>['enctype'=>'multipart/form-data']]); ?>
		
		<div class="media-left">
			<?php echo Html::tag("p",Yii::t("lesson",Element::$TYPE_TITLES[$type]));?>
		</div>

		<div class="media-body">
			<div class="row">
				<div class="col-xs-1">
					<label>Номер блока</label>
					<?php echo Html::textInput("Elements[$count][position]",isset($element['position'])?$element['position']:null,['min'=>1,'type'=>'number','style'=>"width:80px",'class'=>'form-control']);?>
					<?php 
						if($errors && isset($errors['position'])){
							echo Html::tag("p",$errors['position'][0],['class'=>"help-block help-block-error"]);
						}
					?>
				</div>

				<?php if($type == Element::TYPE_TEXT){?>
					<div class="col-xs-6">
						<label>Текст</label>
						<?php echo Widget::widget([
							'name'=>"Elements[$count][content]",
							'value'=>isset($element['id'])?$element['content']:null,
							'options'=>[
								'id'=>"textareaContent_{$block}_{$count}"
							],
						    'settings' => [
						        'lang' => 'ru',
						        'minHeight' => 200,
						        'imageUpload' => Url::to(['/site/image-upload']),
	        					'imageManagerJson' => Url::to(['/site/images-get']),
	        					'fileUpload' => Url::to(['/site/file-upload']),
	        					'fileManagerJson' => Url::to(['/site/files-get']),
	        					'imageDelete' => Url::to(['/site/file-delete']),
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
				<?php }else{ ?>
					<div class="col-xs-6">
						<?php
							echo Html::tag("label",Yii::t("element",'files'));
							echo Html::fileInput("Elements[$count][files]");
							if($errors && isset($errors['files'])){
								echo Html::tag("p",$errors['files'][0],['class'=>"help-block help-block-error"]);
							}else{
								echo "<br>";
							}
							if($type == Element::TYPE_AUDIO){

								if(isset($element['id']) && isset($element->file_name) && $element->file_name){
								?>
									<div>
										<audio controls>
											<source src="<?php echo $element->file?>">
											Ваш браузер не пожжерживает тег audio!
										</audio>
									</div>
								<?php
								}
							
								echo Html::tag("label",Yii::t("element",'icon'));
								echo Html::fileInput("Elements[$count][icon]");
								if($errors && isset($errors['icon'])){
									echo Html::tag("p",$errors['icon'][0],['class'=>"help-block help-block-error"]);
								}else{
									echo "<br>";
								}
								if(isset($element['id']) && isset($element->audio_icon) && $element->audio_icon){
								?>
									<div>
										<img src="<?php echo $element->audio_icon_path?>">
									</div>
								<?php
								}

								// echo $form->field($model,"icon")->fileInput();
								echo Html::tag("label",Yii::t("element",'content'),['class'=>"control-label"]);
								echo Html::textInput("Elements[$count][content]",isset($element['content'])?$element['content']:null,['class'=>'form-control']);
								echo "<br>";
								// echo $form->field($model,"content")->textInput();
								echo Html::tag("label",Yii::t("element",'translate'));
								echo Html::textInput("Elements[$count][translate]",isset($element['translate'])?$element['translate']:null,['class'=>'form-control']);
								echo "<br>";
								// echo $form->field($model,"translate")->textInput();
								echo Html::tag("label",Yii::t("element",'displayInTable'),['for'=>"element-$count-displayInTable"]);
								echo Html::checkbox("Elements[$count][displayInTable]",isset($element['displayInTable'])?$element['displayInTable']:null,['id'=>"element-$count-displayInTable",'value'=>1]);
								// echo $form->field($model,"displayInTable")->checkbox();
							}elseif($type == Element::TYPE_IMAGE && isset($element['id']) && isset($element->file_name) && $element->file_name){
								?>
								<div>
									<img src="<?php echo $element->file?>" width="150px">
								</div>
								<?php
							}
						?>
					</div>
				<?php } ?>

				
				<div class="col-xs-3">
					<?php //echo $form->field($model,'isPublic')->checkbox();?>
					<?php 
						echo Html::tag("label",Yii::t("element",'isPublic'),['for'=>"element-$count-isPublic",'class'=>'control-label']);
						echo Html::checkbox("Elements[$count][isPublic]",isset($element['isPublic'])?$element['isPublic']:null,['id'=>"element-$count-isPublic"]);
					?>
				</div>

				<div class="col-xs-2">
					<div class="btn-group">
						<?php 
							$class_remove = isset($element['id']) ? "removeElementFromDb" : "removeElement";
							$url = isset($element['id']) ? ['lesson/remove-element','id'=>$element['id']] : null;
							$opts = ['class'=>"btn btn-danger {$class_remove}"];
							if(!$url){
								$opts['data-confirm'] = Yii::t('lesson','REMOVE_ELEMENT_CONFIRM');
							}
							echo Html::a("X",$url,$opts);
						?>
					</div>
				</div>
			<?php 
				//echo $form->field($model,'type')->hiddenInput(['value'=>$type])->label(false);
				echo Html::hiddenInput("Elements[$count][type]",$type);
			?>
			<?php 
				echo isset($element['id'])? Html::hiddenInput("Elements[$count][id]",$element->id):"";

				echo $block ? Html::hiddenInput("Elements[$count][block]",$block) : "";
			?>
			</div>
		</div>
	<?php //ActiveForm::end();?>

</div>

