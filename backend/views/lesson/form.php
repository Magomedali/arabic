<?php

use yii\helpers\{Url,Html};
use yii\bootstrap\ActiveForm;

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
		<h2>Edit: <?php echo Html::encode($model->title); ?></h2> 
	</div>
	<div class="col-xs-12">
		<?php $form = ActiveForm::begin(['id'=>'formEditlesson']);?>
		<div class="row">
			<div class="col-xs-3">
				<?php echo $form->field($model,"title")->textInput()?>
			</div>
			<div class="col-xs-3">
				<?php echo $form->field($model,"number")->textInput(['type'=>'number','min'=>1])?>
			</div>
			<div class="col-xs-3">
				<?php echo Html::submitButton(Yii::t('lesson','EDIT_LESSON'),['class'=>'btn btn-success'])?>
			</div>
		</div>
		<?php ActiveForm::end();?>
	
	</div>
</div>

<div class="row">
	<div class="col-xs-6">
		<?php
			;
			if(is_array($blocks) && count($blocks)){
				foreach ($blocks as $key => $b) {

					if($updBlock && isset($updBlock['id']) && $b['id'] == $updBlock['id']){
						$b  = $updBlock;
					}
 
					?>
						<div class="lesson-block">
							<div class="row">
								<div class="col-xs-3">
									<h5><?php echo Yii::t('lesson','BLOCK',['position'=>$b['position']]); ?></h5>
								</div>
							</div>
							<?php $form = ActiveForm::begin(); ?>

								<div class="row">
									<div class="col-xs-3">
										<?php echo $form->field($b,'position')->textInput(['type'=>'number','min'=>1]); ?>
									</div>
									<div class="col-xs-3">
										<?php echo $form->field($b,'isPublic')->checkbox(['id'=>'block#'.$b['id']]);?>
									</div>
									<div class="col-xs-3">
										<?php echo $form->field($b,'lesson')->hiddenInput(['value'=>$model->id])->label(false); ?>
										<?php echo $form->field($b,'id')->hiddenInput(['value'=>$b->id])->label(false); ?>
										<?php echo Html::submitbutton(Yii::t("lesson",'SAVE_BLOCK'),['class'=>'btn btn-primary']); ?>
									</div>
								</div>
							
							<?php ActiveForm::end(); ?>
						</div>
					<?php
				}
			}
		?>
	</div>
</div>

<div class="row">
	<div class="col-xs-6">
		<?php $form = ActiveForm::begin(['id'=>'formNewLesson']); ?>
			<div class="row">
				<div class="col-xs-3">
					<h4><?php echo Yii::t('lesson','NEW_BLOCK'); ?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3">
					<?php echo $form->field($newblock,'position')->textInput(['type'=>'number','min'=>1]); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->field($newblock,'isPublic')->checkbox();?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->field($newblock,'lesson')->hiddenInput(['value'=>$model->id])->label(false); ?>
					<?php echo Html::submitbutton(Yii::t("lesson",'SAVE_BLOCK'),['class'=>'btn btn-primary']); ?>
				</div>
				
			</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
