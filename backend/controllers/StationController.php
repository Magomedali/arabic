<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


use backend\models\{Station,StationSearch};

/**
 * Station controller
 */
class StationController extends Controller
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
                        'actions' => ['index','monitoring', 'error','create','view','map'],
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



    public function actionMonitoring(){
        
        $StationSearch = new StationSearch;
        
        $dataProvider = $StationSearch->search(Yii::$app->request->get());

        $view = $this->renderPartial('monitoring',['dataProvider'=>$dataProvider,'StationSearch'=>$StationSearch]);

        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return ['view'=>$view,'date'=>date("d.m.Y H:i:s",time()),'post'=>Yii::$app->request->queryParams];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        $StationSearch = new StationSearch;
        
        $dataProvider = $StationSearch->search(Yii::$app->request->get());

        $view = $this->renderPartial('monitoring',['dataProvider'=>$dataProvider,'StationSearch'=>$StationSearch]);

        return $this->render('index',['view'=>$view]);
    }




    public function actionCreate($id = null){

        $StandsModels = [];
        if($id){
            $model = Station::findOne($id);
            $StandsModels = $model->stands;
        }

        if(!isset($model) || !isset($model->id) || !$model->id){
            $model = new Station;
        }

        $post = Yii::$app->request->post();
        if($post && isset($post['Station'])){

            if($model->load($post) && $model->save(1)){
                Yii::$app->session->setFlash('success', Yii::t('site','SUCCESS_SAVE_STATION'));

                if(isset($post['Stands'])){
                    $StandsModels = $model->addStands($post['Stands']);
                }

                if(isset($post['PropertiesValue'])){
                    $StandsModels = $model->addProperties($post['PropertiesValue']);
                }

                return $this->redirect(['station/index']);
            }else{
                Yii::$app->session->setFlash('danger', Yii::t('site','ERROR_SAVE_STATION'));
            }

        }

        return $this->render('form',['model'=>$model,'standsModels'=>$StandsModels]);
    }


    public function actionView($id = null){

        if($id == null)
            throw new HttpException(404,'Not Found!');
        
        $model = Station::findOne($id);
        
        if($model === NULL)
            throw new HttpException(404,'Document Does Not Exist');

        

        return $this->render('view',["model"=>$model]);
    }

    public function actionMap(){

        $stations = Station::getMapStations();

        return $this->render("map",['stations'=>$stations]);
    }

}
