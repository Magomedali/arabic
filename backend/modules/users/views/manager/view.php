<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use backend\modules\users\UsersAsset;
use backend\modules\users\models\User;
use backend\modules\users\components\PermissionsTreeWidget;

/* @var $this yii\web\View */
/* @var $model budyaga\users\models\User */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('users', 'USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$assets = UsersAsset::register($this);
?>
<div class="user-view">
    <p>
        <?= Yii::$app->user->can('userUpdate', ['user' => $model]) ? Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : '' ?>
        <?= Yii::$app->user->can('userDelete') ? Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'), 'method' => 'post']]) : ''?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options'=>[
            'class'=>'table table-striped table-bordered detail-view'
        ],
        'formatter'=>[
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'attributes' => [
            'id',
            'fullName',
            'email:email',
            [
                'attribute'=>'email_confirmed',
                'value'=>function($m){
                    return $m->phone_confirmed ? "+" : '-';
                },
                'format'=>'raw',
            ],
            'phone',
            'bdate',
            [
                'attribute'=>'phone_confirmed',
                'value'=>function($m){
                    return $m->phone_confirmed ? "+" : '-';
                },
                'format'=>'raw',
            ],
            [
                'attribute' => 'status',
                'value' => User::getStatusArray()[$model->status]
            ]
        ],
    ]) ?>


    <?php
        if(\Yii::$app->hasModule("rbac")){
            $moduleRbac = \Yii::$app->getModule("rbac");
            echo ($moduleRbac->componentNamespace.'\PermissionsTreeWidget')::widget(['user' => $model->id]);
        }
    ?>

</div>
