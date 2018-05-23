<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Lesson;

/**
 * Site controller
 */
class LessonController extends Controller
{


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','form','view','delete'],
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                ],
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
        ];
    }
    

    /**
     * Displays form for create and update level.
     *
     * @return string
     */
    public function actionForm($id = null)
    {   

        if((int)$id){
            $model = Level::findOne((int)$id);

            if(!isset($model->id)){
                throw new HttpException(404,'Document Does Not Exist');
            }
        }else{
            $model = new Level;
        }
        
        
        $post = Yii::$app->request->post();

        if(isset($post['Level'])){
            if($model->load($post) && $model->save()){
                Yii::$app->session->setFlash("success",Yii::t("level","LEVEL_FORM_SUBMIT_SUCCESS"));
                return $this->redirect(['level/index']);
            }else{
                Yii::$app->session->setFlash("danger",Yii::t("level","LEVEL_FORM_SUBMIT_ERROR"));
            }
        }

        return $this->render('form',['model'=>$model]);
    }





    public function actionView($id){

        if(!$id){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model = Lesson::findOne((int)$id);

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }

        return $this->render('view',[
            'model'=>$model
        ]);
    }





    public function actionDelete($id){

        if(!$id){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model = Lesson::findOne((int)$id);

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model->delete();

        Yii::$app->session->setFlash("success",Yii::t("level","LESSON_REMOVED"));

        if($model->level){
            return $this->redirect(['level/view','id'=>$model->level]);
        }else{
            return $this->redirect(['level/index']);
        }
        
    }



    
}
