<?php
namespace frontend\controllers;


use Yii;
use yii\base\InvalidParamException;
use yii\web\{BadRequestHttpException,Controller};
use yii\filters\{VerbFilter,AccessControl};
use common\models\{User};
use frontend\models\{SignupForm,ConfirmUser,SessionForm,UserSessionsStory};



class ContactsController extends Controller{


	public function behaviors(){
		return [
			'access'=>[
				'class'=>AccessControl::className(),
				'rules'=>[
					[
						'actions'=>['index'],
						'allow'=>true,
						'roles'=>['@'],
					]
				]
			]
		];
	}



	/**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


	public function actionIndex(){

		return $this->render("index",[]);
	}
}
?>