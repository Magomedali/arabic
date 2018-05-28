<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


use backend\modules\users\models\User;

/* @var $this yii\web\View */
/* @var $model budyaga\users\models\User */
/* @var $form yii\widgets\ActiveForm */

$User = User::getUser();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php echo $form->field($model, 'sname')->textInput(['maxlength' => 255]); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 255]); ?>

    <?php echo $form->field($model, 'email')->textInput(['maxlength' => 255]); ?>

    <?php echo $form->field($model, 'status')->dropDownList(User::getStatusArray()); ?>

    <?php echo $form->field($model, 'password')->passwordInput() ?>

    <?php echo $form->field($model, 'confirm_password')->passwordInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('users', 'CREATE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
