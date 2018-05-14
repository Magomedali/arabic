<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

use backend\models\{PropertiesSearch,Properties};

/**
 * Station controller
 */
class PropertiesController extends Controller
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
                        'actions' => ['index', 'error','create','view'],
                        'allow' => true,
                        'roles'=>['superadmin'],
                    ],
                ],
            ],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        
        $PropertiesSearch = new PropertiesSearch();


        $dataProvider = $PropertiesSearch->search(Yii::$app->request->queryParams);

        return $this->render('index',['dataProvider'=>$dataProvider,'PropertiesSearch'=>$PropertiesSearch]);
    }




    public function actionCreate($id = null){

        
        if($id){
            $model = Properties::findOne($id);
        }

        if(!isset($model) || !isset($model->id) || !$model->id){
            $model = new Properties;
        }

        $post = Yii::$app->request->post();
        if($post && isset($post['Properties'])){

            if($model->load($post) && $model->save()){
                Yii::$app->session->setFlash('success', Yii::t('site','SUCCESS_SAVE_STATION'));
                return $this->redirect(['properties/index']);
            }else{
                Yii::$app->session->setFlash('danger', Yii::t('site','ERROR_SAVE_STATION'));
            }
        }

        return $this->render('form',['model'=>$model]);
    }
}
