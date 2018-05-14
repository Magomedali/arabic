<?php
namespace api\modules\apiclient\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use api\modules\apiclient\models\Test;

use api\models\{Request};
use api\modules\RequestSearch;


class TestController extends Controller
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
                        'actions' => ['index','requests','execute-requests','execute-danger'],
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
        
        return $this->render('index',[]);
    }





    public function actionRequests(){

        $test = new Test([
            'host'=>$this->module->api_host
        ]);

        $reqs = $test->getRequests();

        return $this->render('requests',['requests'=>$reqs]);
    }

    




    public function actionExecuteRequests($id = null){

        $test = new Test([
            'host'=>$this->module->api_host
        ]);

        $test->executeRequests($id);

        $answers = $test->completeServerAnsw;

        return $this->render('index',['answers'=>$answers]);
    }




    public function actionExecuteDanger($id = null){

        $test = new Test([
            'host'=>$this->module->api_host
        ]);

        $test->executeRequests($id,false);

        $answers = $test->completeServerAnsw;

        return $this->render('index',['answers'=>$answers]);
    }

}
