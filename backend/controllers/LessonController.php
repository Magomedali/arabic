<?php
namespace backend\controllers;

use Yii;
use yii\web\{Controller,HttpException};
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
                        'actions' => ['index','form','view','delete','get-element-form','remove-block','remove-element','add-element'],
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                    [
                        'actions' => ['images-get','image-upload','file-upload','files-get','file-delete'],
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
            'images-get'=>[
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => 'http://localhost:8081/arabic/files/lesson/',
                'path' => '@files/lesson/',
                //'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.mp3','*.mpeg']],
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => 'http://localhost:8081/arabic/files/lesson/', // Directory URL address, where files are stored.
                'path' => '@files/lesson/', // Or absolute path to directory where files are stored.
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => 'http://localhost:8081/arabic/files/lesson/', // Directory URL address, where files are stored.
                'path' => '@files/lesson/', // Or absolute path to directory where files are stored.
                'uploadOnlyImage' => false, // For any kind of files uploading.
            ],
            'files-get' => [
                'class' => 'vova07\imperavi\actions\GetFilesAction',
                'url' => 'http://localhost:8081/arabic/files/lesson/', // Directory URL address, where files are stored.
                'path' => '@files/lesson/', // Or absolute path to directory where files are stored.
                'options' => ['only' => ['*.txt', '*.md']], // These options are by default.
            ],
            'file-delete' => [
                'class' => 'vova07\imperavi\actions\DeleteFileAction',
                'url' => 'http://localhost:8081/arabic/files/lesson/', // Directory URL address, where files are stored.
                'path' => '@files/lesson/', // Or absolute path to directory where files are stored.
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


        return $this->render('form',[
            'model'=>$model,
            'newblock'=>$newblock,
            'blocks'=>$blocks,
            'updBlock' => $updBlock
        ]);
    }





    public function actionAddElement(){

        $post = Yii::$app->request->post();

        if($post && isset($post['Element']) && isset($post['Element']['block']) && (int)$post['Element']['block']){

            $block = Block::findOne($post['Element']['block']);
            if(!isset($block->id)) return $this->redirect(['level/index']);

            $element = $block->addElement($post['Element']);

            if($element->hasErrors()){
                Yii::$app->session->setFlash("danger",Yii::t("lesson","LESSON_ELEMENT_SAVE_ERROR"));
            }else{
                Yii::$app->session->setFlash("success",Yii::t("lesson","LESSON_ELEMENT_SAVE_SUCCESS"));
            }

            return $this->redirect(['lesson/form','id'=>$block->lesson]);

        }else{
            return $this->redirect(['level/index']);
        }

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

            $get = Yii::$app->request->get();
            $count = isset($get['count']) ? (int)$get['count'] + 1 : 0;
            $type = isset($get['type']) && array_key_exists($get['type'],Element::$TYPE_TITLES) ? $get['type'] : Element::TYPE_TEXT;

            $ans['html'] = $this->renderAjax("elementForm",['block'=>$block->id,'type'=>$type,'count'=>$count]);
            
            return $ans;

        }
        
        return $ans['error'] = 1;
        
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
