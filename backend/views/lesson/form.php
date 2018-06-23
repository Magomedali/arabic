<?php

use yii\helpers\{Url,Html};
use yii\bootstrap\ActiveForm;
use backend\models\Element;
use vova07\imperavi\Widget;

$this->title = Yii::t("lesson","LESSON_TITLE",['title'=>$model->title]);

$level = $model->levelModel;

if(isset($level['id'])){
	$this->params['breadcrumbs'][] = [
		'label' => Yii::t("level","LEVEL",['title'=>$level['title']]),
		'url'   => Url::to(['level/view','id'=>$level['id']])
	];
}

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="col-xs-12">
		<h2>Edit: <?php echo Html::encode($model->title); ?> <?php echo Html::a(Yii::t("lesson",'VIEW'),['lesson/view','id'=>$model->id],['class'=>'btn btn-primary'])?></h2> 
	</div>
	<div class="col-xs-12 formEditlesson">
		<?php $form = ActiveForm::begin(['id'=>'formEditlesson']);?>
		<div class="row">
			<div class="col-xs-1">
				<?php echo $form->field($model,"number")->textInput(['type'=>'number','min'=>1])?>
			</div>
			<div class="col-xs-3">
				<?php echo $form->field($model,"title")->textInput()?>
			</div>			
			<div class="col-xs-2">
				<?php echo $form->field($model,'isPublic')->checkbox();?>
			</div>			
			<div class="col-xs-2">
				<?php echo $form->field($model,'showDesc')->checkbox();?>
			</div>
			<div class="col-xs-3">
				<?php echo Html::submitButton(Yii::t('lesson','EDIT_LESSON'),['class'=>'btn btn-success'])?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<?php echo $form->field($model,'desc')->widget(Widget::className(), [
						'model'=>$model,
						'attribute'=>'desc',
						
					    'settings' => [
					        'lang' => 'ru',
					        'minHeight' => 200,
					        'imageUpload' => Url::to(['/level/image-upload']),
        					'imageManagerJson' => Url::to(['/level/images-get']),
        					'fileUpload' => Url::to(['/level/file-upload']),
        					'fileManagerJson' => Url::to(['/level/files-get']),
        					'imageDelete' => Url::to(['/level/file-delete']),
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
		</div>
		<?php ActiveForm::end();?>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<h3><?php echo Yii::t('lesson',"BLOCK_SETTINGS"); ?> </h3>
		
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<h4>Выберите блок для редактирования:</h4>
		<ul class="pagination">
			<?php foreach ($blocks as $i => $b) {
				?>
				<li class="<?php echo isset($currentBlock['id']) && $b['id']==$currentBlock['id'] ? 'active' : ''; ?>"><?php echo Html::a("Блок ".$b->position,['lesson/form','id'=>$model->id,'block_id'=>$b->id])?></li>
				<?php
			}?>
			<li><?php echo Html::a("+ добавить новый блок",['lesson/form','id'=>$model->id],['title'=>'Добавить новый блок']);?></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<?php
			$b  = $currentBlock;
					?>
		<div class="panel panel-default lesson-block">
			<?php $form = ActiveForm::begin(['options'=>['class'=>'form-inline','enctype'=>'multipart/form-data']]); ?>
			<div class="panel-heading">
				<div class="row">
						<div class="col-xs-1">
							<h5><?php echo Yii::t('lesson','BLOCK',['position'=>$b['position']]); ?></h5>
						</div>
						<div class="col-xs-2">
							<?php echo $form->field($b,'position')->textInput(['type'=>'number','min'=>1,'style'=>"width: 85px;"]); ?>
						</div>
						<div class="col-xs-2">
							<?php echo $form->field($b,'isPublic')->checkbox(['id'=>"blockisPublic"]);?>
						</div>
						<div class="col-xs-2">
							<?php echo $form->field($b,'displayInline')->checkbox(['id'=>"blockdisplayInline"]);?>
						</div>
						<div class="col-xs-3 col-xs-offset-2">
							<div class="btn-group">
								<?php echo Html::submitbutton(Yii::t("lesson",'SAVE_BLOCK'),['class'=>'btn btn-primary']); ?>
								<?php echo isset($b['id']) ? Html::a(Yii::t("lesson",'REMOVE_BLOCK'),['lesson/remove-block','id'=>$b['id']],['class'=>'btn btn-danger','data-confirm'=>Yii::t('lesson','REMOVE_BLOCK_CONFIRM')]): "";?>
							</div>
						</div>
						<?php echo $form->field($b,'lesson')->hiddenInput(['value'=>$model->id])->label(false); ?>
						
						<?php echo isset($b->id) ? $form->field($b,'id')->hiddenInput(['value'=>$b->id])->label(false) : ""; ?>

					
				</div>
							
							
				<div class="row">
					<div class="col-xs-6">
						<?php 
							echo Html::dropDownList("element_type",Element::TYPE_TEXT,Element::$TYPE_TITLES,['class'=>'form-control new-element-type']);
										?>
					</div>
					<div class="col-xs-6">
						<?php 
							echo Html::a(Yii::t('lesson','ADD_ELEMENT'),['lesson/get-element-form','id'=>isset($b['id']) ? $b['id'] : 0],['class'=>'btn btn-primary btn-add-element']);
										?>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="block-elements">
							<?php
								$count_el = 1;

								if(isset($errorElements) && is_array($errorElements)){
									$count_el = count($errorElements);
									foreach ($errorElements as $key => $be) {
										echo $this->render("elementForm",['element'=>$be,'block'=>$b->id,'type'=>$be['type'],'count'=>$key+1]);
									}
								}

								$block_elements = $b->elements;
								
								foreach ($block_elements as $key => $be) {
									$count_el = $key+1;
									echo $this->render("elementForm",['element'=>$be,'block'=>$b->id,'type'=>$be['type'],'count'=>$count_el]);
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>




<?php 


$js = <<<JS
			var send_get_element = 0;
			$("body").on("click",".btn-add-element",function(event){
				event.preventDefault();

				var lesson_block = $(this).parents(".lesson-block");
				var count = lesson_block.find(".block-elements .block-element").length;
				var type = lesson_block.find(".new-element-type").val();

				if(type && !send_get_element){
					$.ajax({
						url:$(this).attr("href"),
						data:{
							count:count,
							type:type
						},
						dataType:"json",
						type:"GET",
						beforeSend:function(){
							send_get_element = 1;
						},
						success:function(json){
							if(json.hasOwnProperty("html")){
								lesson_block.find(".block-elements").append(json.html);
							}
						},
						error:function(msg){
							console.log(msg);
						},
						complete:function(){
							send_get_element = 0;
						},
					});
				}
			});

									
			$("body").on("click",".removeElement",function(event){
				event.preventDefault();
				$(this).parents(".block-element").remove();			
			});


			var send_removeElement = 0;
			$("body").on("click",".removeElementFromDb",function(event){
				event.preventDefault();
				if(!confirm("Confirm your action!!!")){
					return;
				}
				var element = $(this).parents(".block-element");

				if(element && !send_removeElement){
					$.ajax({
						url:$(this).attr("href"),
						dataType:"json",
						type:"GET",
						beforeSend:function(){
							send_removeElement = 1;
						},
						success:function(json){
							if(json.hasOwnProperty("res") && json.res == 1){
								element.remove();
							}
						},
						error:function(msg){
							console.log(msg);
						},
						complete:function(){
							send_removeElement = 0;
						},
					});
				}
			})
						
JS;
	$this->registerJs($js);
?>

