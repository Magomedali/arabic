<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;
use common\models\{Level,Lesson};

$this->title = Yii::t('site',Yii::$app->name);

?>
<div class="row">
	<div class="col-xs-12">
		<h1><?php echo Yii::t('site','MAIN_HEADER_TITLE')?></h1>
	</div>
</div>
<div class="row">
	
	<?php if(\Yii::$app->user->isGuest){?>
	<div class="col-xs-4">
		<?php $form = ActiveForm::begin(['action'=>['site/signup'],'id' => 'form-signup']); ?>

                <?php echo $form->field($signUpModel, 'phone')->textInput() ?>

                <?php echo $form->field($signUpModel, 'email')->textInput() ?>

                <?php echo $form->field($signUpModel, 'password')->passwordInput() ?>

                <?php echo $form->field($signUpModel, 'confirm_password')->passwordInput() ?>

                <?php echo $form->field($signUpModel, 'accept_condition')->checkbox();?>
                
                <div class="form-group">
                    <?php echo Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    <?php echo Html::a('Login',['site/login'],['class' => 'btn btn-success',]) ?>
                </div>
        <?php ActiveForm::end(); ?>
	</div>
	<?php }else{ ?>
	<div class="col-xs-8">
		<?php 

			$user = Yii::$app->user->identity;
			$lesson = $user->getCurrentLesson();
			$nextL = isset($lesson->id) ? $lesson->nextLesson : null;
			if(isset($nextL->id)){

				?>
				
				<?php if($nextL->showDesc){?>
					<div class="level_desc">
						<?php echo $nextL->desc;?>
					</div>
				<?php } ?>


				<div>
					<?php echo Html::a("Продолжить обучение",['level/lesson','id'=>$nextL->id],['class'=>'btn btn-success']);?>
				</div>

				<?php
			}else{
				$level = new Level();
				$firstLevel = $level->firstLevel;

				if(isset($firstLevel->id)){
				?>

				<?php if($firstLevel->showDesc){?>
					<div class="level_desc">
						<?php echo $firstLevel->desc;?>
					</div>
				<?php } ?>
				<div>
					<?php echo Html::a("Начать обучение",['level/lessons','id'=>$firstLevel->id],['class'=>'btn btn-success']);?>
				</div>

				<?php
				}else{
				?>

				<div>
					<h3>Нет доступных курсов!</h3>
				</div>

				<?php
				}
			}
		?>
	</div>
	<?php } ?>
</div>