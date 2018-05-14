<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?php  echo $form->field($model, 'login')->textInput(['autofocus' => true]); ?>

                <?php  echo $form->field($model, 'password')->passwordInput(); ?>

                <?php  echo $form->field($model, 'rememberMe')->checkbox(); ?>

                <?php
                    if($model->hasErrors()){
                        if($model->unConfirmedEmail()){
                            ?>
                            <div style="color:#999;margin:1em 0">
                                После регистрации вы не подтвердили почтовый адрес. Для входа в личный кабинет необхдимо его подтведить. <?= Html::a('Получить инструкцию подтверждения на почту '.$model->login, ['site/send-confirm-email','e'=>$model->login]); ?>.
                            </div>
                            <?php
                        }elseif($model->unConfirmedPhone()){
                            ?>
                            <div style="color:#999;margin:1em 0">
                                После регистрации вы не подтвердили номер телефона. Для входа в личный кабинет необхдимо его подтведить. <?= Html::a('Получить инструкцию подтверждения на телефон '.$model->login, ['site/send-confirm-phone','p'=>$model->login]); ?>.
                            </div>
                            <?php
                        }
                ?>

                <?php
                    }
                ?>
                
                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div>
                

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <?php
                echo Html::a("Вход через Егпп",['site/auth-egpp']);
            ?>
        </div>
    </div>
</div>
