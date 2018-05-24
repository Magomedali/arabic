<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\{Lesson,Block};

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
            $model = Lesson::findOne((int)$id);

            if(!isset($model->id)){
                throw new HttpException(404,'Document Does Not Exist');
            }
        }else{
            $model = new Lesson;
        }
        


        $newblock = new Block;
        $blocks = $model->blocks;
        $post = Yii::$app->request->post();
        $updBlock = null;
        if(isset($post['Lesson'])){
            if($model->load($post) && $model->save()){
                Yii::$app->session->setFlash("success",Yii::t("level","LESSON_FORM_SUBMIT_SUCCESS"));
            }else{
                Yii::$app->session->setFlash("danger",Yii::t("level","LESSON_FORM_SUBMIT_ERROR"));
            }
        }




        if(isset($post['Block'])){
            $post['Block']['lesson'] = $model->id;
            if(isset($post['Block']['id'])){

                $updBlock = Block::findOne((int)$post['Block']['id']);

                if(isset($updBlock->id)){
                    if($updBlock->load($post) && $updBlock->save()){
                        Yii::$app->session->setFlash("success",Yii::t("level","LESSON_FORM_BLOCK_SUBMIT_SUCCESS"));
                        return $this->redirect(['lesson/form','id'=>$model->id]);
                    }
                }

            }else{
               $newblock = $model->addBlock($post);

                if($newblock instanceof Block && !$newblock->hasErrors()){
                    Yii::$app->session->setFlash("success",Yii::t("level","LESSON_FORM_BLOCK_SUBMIT_SUCCESS"));
                        
                    return $this->redirect(['lesson/form','id'=>$model->id]);
                }else{
                    Yii::$app->session->setFlash("danger",Yii::t("level","LESSON_FORM_BLOCK_SUBMIT_ERROR"));
                } 
            }
        }


        return $this->render('form',['model'=>$model,'newblock'=>$newblock,'blocks'=>$blocks,'updBlock' => $updBlock]);
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
