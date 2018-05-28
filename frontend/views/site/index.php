<?php

use yii\helpers\{Html,Url};
use yii\bootstrap\ActiveForm;

$this->title = \Yii::$app->name;

?>
<div class="row">
	<div class="col-xs-12">
		<h1><?php echo Yii::t('site','MAIN_HEADER_TITLE')?></h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-8">
		<div id="map">
			
		</div>
	</div>
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
</div>