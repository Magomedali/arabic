<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;
use backend\models\Element;
use vova07\imperavi\Widget;

if(is_array($block_elements) && count($block_elements)){
	foreach ($block_elements as $key => $ble) {
		
?>
<div class="media well block-element">	

	<?php $form = ActiveForm::begin(['action'=>Url::to(['lesson/add-element']),'options' =>['enctype'=>'multipart/form-data']]); ?>

	<div class="media-left">
		<?php
			echo Html::tag("p",Yii::t("lesson",Element::$TYPE_TITLES[$ble['type']]));
		?>
	</div>

	<div class="media-body">
		
		<div class="row">
			<div class="col-xs-1">	
				<?php echo $form->field($ble,'position')->textInput(['min'=>1,'type'=>'number']); ?>
			</div>

			<?php if($ble['type'] == Element::TYPE_TEXT){ ?>
				<div class="col-xs-6">
					<?php echo  $form->field($ble,'content')->widget(Widget::className(), [
							'model'=>$ble,
							'attribute'=>'content',
							'options'=>[
								'id'=>"textareaContent_{$ble['block']}_{$key}"
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
						if($ble['type'] == Element::TYPE_VIDEO){
							echo $form->field($ble,"files")->fileInput();
						}elseif($ble['type'] == Element::TYPE_AUDIO){
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


							echo $form->field($ble,"icon")->fileInput();
							if($ble->audio_icon){
							?>
								<div>
									<img src="<?php echo $ble->audio_icon_path?>">
								</div>
							<?php
							}
									
						}elseif($ble['type'] == Element::TYPE_IMAGE){
						
							echo $form->field($ble,"files")->fileInput();
							
							if($ble['file_name']){
							
							?>
								
								<div>
									<img src="<?php echo $ble->file?>" width="150px">
								</div>
							<?php
							}
						}
					?>
				</div>
			<?php } ?>

			<div class="col-xs-3">
				<?php echo $form->field($ble,'isPublic')->checkbox(['id'=>'element#'.$ble['id']."isPublic"]);?>
			</div>

			<div class="col-xs-2 <?php echo $ble['type'] != Element::TYPE_TEXT ? "" : "col-xs-offset-3" ; ?>">
				<div class="btn-group">
					
				<?php 
					echo Html::submitInput(Yii::t('site','SAVE'),['class'=>'btn btn-success']);
				
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
		</div>
		<?php echo isset($ble['id']) ?  $form->field($ble,'id')->hiddenInput()->label(false) : "";?>
		<?php echo $form->field($ble,'block')->hiddenInput(['value'=>$block])->label(false); ?>
	</div>
	<?php ActiveForm::end();?>
</div>
<?php 
		}
	}
?>