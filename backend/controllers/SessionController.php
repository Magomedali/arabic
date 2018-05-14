<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


use backend\models\{Session,SessionSearch};

/**
 * Station controller
 */
class SessionController extends Controller
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
                        'actions' => ['index', 'monitoring','error','accept','send'],
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
        
        $SessionSearch = new SessionSearch;
        
        $dataProvider = $SessionSearch->search(Yii::$app->request->get());

        $view = $this->renderPartial('monitoring',['dataProvider'=>$dataProvider,'SessionSearch'=>$SessionSearch]);

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
        $SessionSearch = new SessionSearch;
        
        $dataProvider = $SessionSearch->search(Yii::$app->request->get());

        $view = $this->renderPartial('monitoring',['dataProvider'=>$dataProvider,'SessionSearch'=>$SessionSearch]);

        return $this->render('index',['view'=>$view]);
    }




    


    public function actionAccept($id = null){

        if($id == null)
            throw new HttpException(404,'Not Found!');
        
        $model = Session::findOne($id);
        
        if($model === NULL)
            throw new HttpException(404,'Document Does Not Exist');

        
        if($model->accept()){
            Yii::$app->session->setFlash('success', Yii::t('site','SESSION_ACCEPTED_SUCCESSFULL'));
        }else{
            Yii::$app->session->setFlash('danger', Yii::t('site','SESSION_NOT_ACCEPTED'));
        }

        return $this->redirect(["session/index"]);
    }




    public function actionSend($id = null){

        if($id == null)
            throw new HttpException(404,'Not Found!');
        
        $model = Session::findOne($id);
        
        if($model === NULL)
            throw new HttpException(404,'Document Does Not Exist');

        $method = new \api\models\methods\MethodSessionStart();
        
        $data['MethodSessionStart']['sessionId'] = $model->id;
        $data['MethodSessionStart']['stationCode'] = $model->station->code;
        $data['MethodSessionStart']['standNumber'] = $model->stand->number;
        $data['MethodSessionStart']['clientName'] = $model->client->email;
        
        if($method->create($data)){
            Yii::$app->session->setFlash('success', Yii::t('site','SESSION_ACCEPTED_SUCCESSFULL'));
        }else{
            Yii::$app->session->setFlash('danger', Yii::t('site','SESSION_NOT_ACCEPTED'));
        }

        return $this->redirect(["session/index"]);
    }

}
