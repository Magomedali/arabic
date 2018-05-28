<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;

print_r($model->getErrors());
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="col-lg-4">
                <?php echo $form->field($model, 'phone')->textInput() ?>

                <?php echo $form->field($model, 'email')->textInput() ?>

                <?php echo $form->field($model, 'password')->passwordInput() ?>

                <?php echo $form->field($model, 'confirm_password')->passwordInput() ?>

                <?php echo $form->field($model, 'accept_condition')->checkbox();?>
                
                <div class="form-group">
                    <?php echo Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
        </div>
        <div class="col-lg-4">

                <?php echo $form->field($model, 'sname')->textInput(['autofocus' => true]) ?>

                <?php echo $form->field($model, 'name')->textInput() ?>

                <?php echo $form->field($model, 'patronymic') ?>

                <?php echo $form->field($model, 'bdate')->input("date") ?>
                
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
