<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

use backend\modules\profiler\models\User;
use backend\modules\profiler\ProfilerAsset;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \budyaga\users\models\User */

$this->title = Yii::t('profiler', 'PROFILE');
$this->params['breadcrumbs'][] = $this->title;
ProfilerAsset::register($this);
?>
<div class="site-profile">
    <div class="row">
        <div class="col-xs-12 col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('profiler', 'PERSONAL_INFO')?></div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'form-profile']); ?>
                    <?= $form->field($model, 'name')->textInput()?>
                    <?= $form->field($model, 'sname')->textInput()?>
                    <?= $form->field($model, 'patronymic')->textInput()?>
                    
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('profiler', 'SAVE'), ['class' => 'btn btn-primary', 'name' => 'profile-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('profiler', 'CHANGE_PASSWORD')?></div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'form-password']); ?>
                    <?php if ($model->password_hash != '') : ?>
                        <?= $form->field($changePasswordForm, 'old_password')->passwordInput(); ?>
                    <?php endif;?>
                    <?= $form->field($changePasswordForm, 'new_password')->passwordInput(); ?>
                    <?= $form->field($changePasswordForm, 'new_password_repeat')->passwordInput(); ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('profiler', 'SAVE'), ['class' => 'btn btn-primary', 'name' => 'password-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('profiler', 'CHANGE_EMAIL')?></div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'form-email']); ?>
                    <?= $form->field($changeEmailForm, 'new_email')->input('email'); ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('profiler', 'SAVE'), ['class' => 'btn btn-primary', 'name' => 'email-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            
        </div>
    </div>
</div>
