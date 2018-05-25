<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\{Lesson,Block,Element};

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
                        'actions' => ['index','form','view','delete','get-element-form','remove-block','remove-element'],
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
        $newBlockElements = array();
        $blocks = $model->blocks;
        $errorElements = [];

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
                    
                    if(isset($post['Elements']) && count($post['Elements']) > 0){
                        $errorElements = $updBlock->addElements($post['Elements']);
                    }
                    
                    if($updBlock->load($post) && $updBlock->validate() && !count($errorElements)){
                        
                        $updBlock->save();
                        
                        Yii::$app->session->setFlash("success",Yii::t("level","LESSON_FORM_BLOCK_SUBMIT_SUCCESS"));
                        return $this->redirect(['lesson/form','id'=>$model->id]);
                    
                    }
                }

            }else{
                $newblock = $model->addBlock($post);

                if($newblock instanceof Block && !$newblock->hasErrors()){
                    
                    Yii::$app->session->setFlash("success",Yii::t("level","LESSON_FORM_BLOCK_SUBMIT_SUCCESS"));
                    
                    if(isset($post['Elements']) && count($post['Elements']) > 0){
                        
                        $newblock->addElements($post['Elements']);
                    
                    }
                    
                    return $this->redirect(['lesson/form','id'=>$model->id]);

                }else{
                    
                    Yii::$app->session->setFlash("danger",Yii::t("level","LESSON_FORM_BLOCK_SUBMIT_ERROR"));
                    
                    if(isset($post['Elements']) && count($post['Elements']) > 0){
                        
                        $newBlockElements = $post['Elements'];
                    
                    }
                } 
            }
        }


        return $this->render('form',[
            'model'=>$model,
            'newblock'=>$newblock,
            'blocks'=>$blocks,
            'updBlock' => $updBlock,
            'newBlockElements'=>$newBlockElements,
            'errorElements'=>$errorElements
        ]);
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





    public function actionGetElementForm($id = null){
        
        if(!Yii::$app->request->isAjax){
            return $this->redirect(['level/index']);
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if((int)$id){
            $block = Block::findOne((int)$id);
            if(!isset($block->id)){
                return $ans['error'] = 1;
            }
        }else{
            $block = new Block;
        }

        $get = Yii::$app->request->get();
        $count = isset($get['count']) ? (int)$get['count'] : 0;
        $type = isset($get['type']) && array_key_exists($get['type'],Element::$TYPE_TITLES) ? $get['type'] : Element::TYPE_TEXT;

        $ans['html'] = $this->renderPartial("elementForm",['count'=>$count,'type'=>$type,'block'=>$block]);
        
        return $ans;
    }





    public function actionRemoveBlock($id){
        if(!$id){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model = Block::findOne((int)$id);

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model->deleteBlock();

        Yii::$app->session->setFlash("success",Yii::t("level","BLOCK_REMOVED"));

        if($model->lesson){
            return $this->redirect(['lesson/form','id'=>$model->lesson]);
        }else{
            return $this->redirect(['level/index']);
        }
    }



    public function actionRemoveElement($id){


        if(!Yii::$app->request->isAjax){
            return $this->redirect(['level/index']);
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(!$id){
            return ['res' => 0];
        }

        $model = Element::findOne((int)$id);

        if(!isset($model->id)){
            return ['res' => 0];
        }
        
        $model->deleteElement();

        return ['res' => 1];
    }
    
}
