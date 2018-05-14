<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['profiler/user/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->fullName ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
