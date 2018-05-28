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

    <?php echo $form->field($model, 'patronymic')->textInput(['maxlength' => 255]); ?>

    <?php //echo $form->field($model, 'email')->textInput(['maxlength' => 255]); ?>

    <?php echo $form->field($model, 'bdate')->textInput(['type'=>'date']); ?>

    <?php echo $form->field($model, 'status')->dropDownList(User::getStatusArray()); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('users', 'CREATE') : Yii::t('users', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
