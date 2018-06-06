<?php
namespace frontend\controllers;


use Yii;
use yii\base\InvalidParamException;
use yii\web\{BadRequestHttpException,Controller,HttpException};
use yii\filters\{VerbFilter,AccessControl};
use common\models\{User,Level,Lesson};



class LevelController extends Controller{


	public function behaviors(){
		return [
			'access'=>[
				'class'=>AccessControl::className(),
				'rules'=>[
					[
						'actions'=>['index','lessons','lesson','level-completed'],
						'allow'=>true,
						'roles'=>[],
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




	public function actionLessons($id){
		
		if(!$id){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model = Level::findOne((int)$id);

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }
        $lessons = $model->lessons;

        return $this->render("lessons",['model'=>$model,'lessons'=>$lessons]);
	}



    public function actionLevelCompleted($id){
        
        if(!$id){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model = Level::findOne((int)$id);

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }
        

        return $this->render("levelCompleted",['model'=>$model]);
    }
    



	public function actionLesson($id){
		
		if(!$id){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model = Lesson::findOne((int)$id);

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }
        

        return $this->render("lesson",[
        	'model'=>$model
        ]);
	}



}
?>