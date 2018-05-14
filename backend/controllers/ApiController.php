<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


use api\models\{Request};
use api\modules\RequestSearch;

/**
 * Station controller
 */
class ApiController extends Controller
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
                        'actions' => ['index', 'monitoring'],
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
        
        $RequestSearch = new RequestSearch;
        
        $dataProvider = $RequestSearch->search(Yii::$app->request->get());

        $view = $this->renderPartial('monitoring',['dataProvider'=>$dataProvider,'RequestSearch'=>$RequestSearch]);

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
        $RequestSearch = new RequestSearch;
        
        $dataProvider = $RequestSearch->search(Yii::$app->request->get());

        $view = $this->renderPartial('monitoring',['dataProvider'=>$dataProvider,'RequestSearch'=>$RequestSearch]);

        return $this->render('index',['view'=>$view]);
    }



}
