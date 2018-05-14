<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\users\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$User = User::getUser();

$this->title = Yii::t('users', 'USERS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <?= (Yii::$app->user->can('superadmin')) ? Html::a(Yii::t('users', 'CREATE'), ['create'], ['class' => 'btn btn-success']) : ''?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'formatter'=>[
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'fullName:text:ФИО',
            'email:email',
            [
                'attribute'=>'email_confirmed',
                'label'=>'Подтверждение E-mail',
                'format'=>'raw',
                'value'=>function($m){
                    return $m->email_confirmed ? "+" : "-";
                }
            ],
            'phone',
            [
                'attribute'=>'phone_confirmed',
                'label'=>'Подтверждение телефона',
                'format'=>'raw',
                'value'=>function($m){
                    return $m->phone_confirmed ? "+" : "-";
                }
            ],
            'egpp_id:text:Идентификатор в ЕГПП',
            'bdate:date:ДР',
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->status == $data::STATUS_ACTIVE ? "Активен" : "Не активен";
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {permissions}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        if (!Yii::$app->user->can('superadmin', ['user' => $model])) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update' => function ($url, $model, $key) {
                        if (!Yii::$app->user->can('superadmin', ['user' => $model])) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                    'permissions' => function ($url, $model, $key) {
                        if (!\Yii::$app->hasModule("rbac") || !Yii::$app->user->can('superadmin', ['user' => $model])) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('users', 'PERMISSIONS'),
                            'aria-label' => Yii::t('users', 'PERMISSIONS'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-cog"></span>', ['/rbac/rbac/permissions','id'=>$model->id], $options);
                    },
                    'delete' => function($url, $model, $key){
                        if (!Yii::$app->user->can('superadmin', ['user' => $model])) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    }
                ]
            ],
        ],
    ]); ?>

</div>
