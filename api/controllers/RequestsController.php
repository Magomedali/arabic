<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use api\models\{Request};

class RequestsController extends Controller
{
    
	public function actionIndex(){

		$r = new Request();
		return $r->requests();
	}


	public function actionComplete($params = 1){

		$r = new Request();
		
		return $r->complete();
	}

	
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter' ] = [
              'class' => \yii\filters\Cors::className(),
        ];

        
     
     	$behaviors['contentNegotiator'] = [
		    'class' => \yii\filters\ContentNegotiator::className(),
		    'formats' => [
		        'application/json' => \yii\web\Response::FORMAT_JSON,
		        //'application/xml' => \yii\web\Response::FORMAT_XML,
		    ],
		];

		// $behaviors['access'] = [
		//     'class' => \yii\filters\AccessControl::className(),
		//     'only' => ['create', 'update', 'delete'],
		//     'rules' => [
		//         [
		//             'actions' => ['create', 'update', 'delete'],
		//             'allow' => true,
		//             'roles' => ['@'],
		//         ],
		//     ],
		// ];
        // В это место мы будем добавлять поведения (читай ниже)
        return $behaviors;
    }

 //    public function checkAccess($action, $model = null, $params = [])
	// {
	//     // проверяем может ли пользователь редактировать или удалить запись
	//     // выбрасываем исключение ForbiddenHttpException если доступ запрещен
	//     if ($action === 'update' || $action === 'delete') {
	//         if (1 !== \Yii::$app->user->id)
	//             throw new \yii\web\ForbiddenHttpException(sprintf('You can only %s lease that you\'ve created.', $action));
	//     }
	// }

    protected function verbs(){
    	return [
    		'complete'=>['PUT']
    	];
    }

	
}
?>