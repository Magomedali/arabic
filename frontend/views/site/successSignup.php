<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Учетная запись создана!';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?php echo Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-xs-12">
            <p><?php echo Html::encode($model->fullName)?>, спасибо что зарегистрировались на нашем сайте.</p>
            <p>Для входа в личный кабинет, необходимо подтвердить вашу учетную запись, инструкция по подтверждению учетной записи была выслана на вашу почту <?php echo Html::encode($model->email); ?> и на номер вашего телефона <?php echo Html::encode($model->phone); ?></p>
            <p>Для повторного получения инструкции подтверждения перейдите по соответствующей ссылке</p>
            <p><?php echo Html::a("Отправить на почту",['site/send-confirm-email','e'=>$model->email]);?></p>
            <p><?php echo Html::a("Отправить на телефон",['site/send-confirm-phone','p'=>$model->phone]);?></p>
        </div>
    </div>
</div>