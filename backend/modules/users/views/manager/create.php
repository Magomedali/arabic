<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model budyaga\users\models\User */

$this->title = Yii::t('users', 'CREATE_USER');
$this->params['breadcrumbs'][] = ['label' => Yii::t('users', 'USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_formCreate', [
        'model' => $model,
    ]) ?>

</div>
