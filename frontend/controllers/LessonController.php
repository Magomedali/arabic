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
						'actions'=>['index','process','open','block'],
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
		if(!Yii::$app->user->isGuest && isset($post['lesson']) && (int)$post['lesson'] && isset($post['block']) && (int)$post['block']){

			$lesson = Lesson::findOne((int)$post['lesson']);

			if(isset($lesson->id)){

				$block = $lesson->getBlockById((int)$post['block']);

				if(isset($block->id) && Yii::$app->user->identity->processLesson($lesson,$block)){

					Yii::$app->session->setFlash("success","Поздравляем вас, модуль пройден!");

					$nextBlock = $block->nextBlock;
					if(isset($nextBlock->id)){
						return $this->redirect(['lesson/block','id'=>$lesson->id,'block_id'=>$nextBlock->id]);
					}

					$nextLesson = $lesson->nextLesson;
					if(isset($nextLesson->id)){
						//Перенаправляем на след урок					
						return $this->redirect(['lesson/open','id'=>$nextLesson->id]);
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



	public function actionOpen($id){
		
		if(!$id){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model = Lesson::find()->where(['id'=>(int)$id,'isPublic'=>true])->one();

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }
        
        
        $currentBlock = $model->firstBlock;
        if(!isset($currentBlock->id)){
            return $this->redirect(['level/lesson','id'=>$model->id]);
        }

        $blocks = $model->publicBlocks;

        return $this->render("block",[
        	'model'=>$model,
        	'blocks'=>$blocks,
        	'currentBlock'=>$currentBlock
        ]);
	}




	public function actionBlock($id){
		
		$get = Yii::$app->request->get();
		if(!$id){
            throw new HttpException(404,'Document Does Not Exist');
        }

        if(!isset($get['block_id']) || !(int)$get['block_id'])
        	throw new HttpException(404,'Document Does Not Exist');

        $model = Lesson::find()->where(['id'=>(int)$id,'isPublic'=>1])->one();

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }
        
        
        $currentBlock = $model->getBlockById((int)$get['block_id']);
        if(!isset($currentBlock->id)){
            return $this->redirect(['level/lesson','id'=>$model->id]);
        }

        $blocks = $model->publicBlocks;
        return $this->render("block",[
        	'model'=>$model,
        	'blocks'=>$blocks,
        	'currentBlock'=>$currentBlock
        ]);
	}
}
?>