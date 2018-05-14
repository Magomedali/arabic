<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->email_token,'key'=>$user->auth_key]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->sname." ".$user->name) ?>,</p>

    <p>Follow the link below to confirm your profile:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
