<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-phone', 'key'=>$user->phone,'pincode' => $pincode]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->sname." ".$user->name) ?>,</p>

    <p>Follow the link below to confirm your phone profile:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
