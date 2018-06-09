<?php
namespace frontend\controllers;


use Yii;
use yii\base\InvalidParamException;
use yii\web\{BadRequestHttpException,Controller,HttpException};
use yii\filters\{VerbFilter,AccessControl};
use common\models\{User,Level,Lesson};


class LessonController extends Controller{


	public function behaviors(){
		return [
			'access'=>[
				'class'=>AccessControl::className(),
				'rules'=>[
					[
						'actions'=>['index','process'],
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
            ]
        ];
    }


	public function actionIndex(){

		return $this->render("index",[]);
	}


	public function actionProcess(){

		$post = Yii::$app->request->post();
		if(!Yii::$app->user->isGuest && isset($post['lesson']) && (int)$post['lesson']){

			$lesson = Lesson::findOne((int)$post['lesson']);

			if(isset($lesson->id)){
				if(Yii::$app->user->identity->processLesson($lesson)){

					Yii::$app->session->setFlash("success","Поздравляем вас, урок пройден!");

					$nextLesson = $lesson->nextLesson;
					if(isset($nextLesson->id)){
						//Перенаправляем на след урок					
						return $this->redirect(['level/lesson','id'=>$nextLesson->id]);
					
					}else{
						//Перенаправляем на след уровень
						return $this->render('levelCompleted',['model'=>$lesson->levelModel]);
					}

				}else{
					Yii::$app->session->setFlash("danger","Извините, произошла ошибка, обратитесь к администратору!");
					return $this->redirect(['level/lesson','id'=>$lesson->id]);
				}
			}

		}

		return $this->redirect(['site/index']);
	}


}
?>