<?php
namespace backend\controllers;

use Yii;
use yii\web\{Controller,HttpException};
use yii\filters\AccessControl;
use backend\models\{Level,LevelSearch};

/**
 * Site controller
 */
class LevelController extends Controller
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
     * Displays level main page.
     *
     * @return string
     */
    public function actionIndex()
    {   

        $filterModel = new LevelSearch;
        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);


        return $this->render('index',["filterModel"=>$filterModel,'dataProvider'=>$dataProvider]);
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

        $model = Level::findOne((int)$id);

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }

        return $this->render('view',['model'=>$model]);
    }





    public function actionDelete($id){

        if(!$id){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model = Level::findOne((int)$id);

        if(!isset($model->id)){
            throw new HttpException(404,'Document Does Not Exist');
        }

        $model->delete();

        Yii::$app->session->setFlash("success",Yii::t("level","LEVEL_REMOVED"));

        return $this->redirect(['level/index']);
    }
    
}
