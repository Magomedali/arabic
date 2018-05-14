<?php
namespace frontend\controllers;


use Yii;
use yii\base\InvalidParamException;
use yii\web\{BadRequestHttpException,Controller};
use yii\filters\{VerbFilter,AccessControl};
use common\models\{User};
use frontend\models\{SignupForm,ConfirmUser,SessionForm,UserSessionsStory};



class ProfileController extends Controller{


	public function behaviors(){
		return [
			'access'=>[
				'class'=>AccessControl::className(),
				'rules'=>[
					[
						'actions'=>['index','change','add-phone','send-confirm-email','add-email','send-confirm-phone','story'],
						'allow'=>true,
						'roles'=>['@'],
					]
				]
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


	public function actionIndex(){

		if(Yii::$app->user->isGuest)
			return $this->redirect(["site/login"]);

		$sessionModel = new SessionForm;
		$post = Yii::$app->request->post();

		if($post && isset($post['SessionForm'])){
			if($sessionModel->load($post) && $sessionModel->start()){
				Yii::$app->session->setFlash('success',Yii::t('profile',"SESSION_REGISTERED"));
				return $this->redirect(["profile/index"]);
			}else{
				Yii::$app->session->setFlash('danger',Yii::t('profile',"SESSION_REGISTERED_ERROR"));
			}
		}

		if($post && isset($post['Stop'])){
			$id= (int)$post['Stop']['session_id'];
			$session = Yii::$app->user->identity->getActualSessionById($id);

			if($session && isset($session->id)){
				if($session->stop()){
					Yii::$app->session->setFlash('success',Yii::t('profile',"SESSION_SEND_REQUEST_STOP"));
					
				}else{
					Yii::$app->session->setFlash('danger',Yii::t('profile',"SESSION_NOT_SENDED_REQUEST_STOP"));
				}
			}else{
				Yii::$app->session->setFlash('danger',Yii::t('profile',"SESSION_NOT_FOUNDED"));
			}
			return $this->redirect(["profile/index"]);
		}

		return $this->render("index",["sessionModel"=>$sessionModel]);
	}



	public function actionStory(){

		
		$report = new UserSessionsStory;

		$dataProvider = $report->search(Yii::$app->request->queryParams);

		return $this->render("story",['dataProvider'=>$dataProvider,'report'=>$report]);

	}



	public function actionChange(){

		$model = Yii::$app->user->identity;

		if(!isset($model->id))
		 	return $this->redirect(["site/login"]);

		$post = Yii::$app->request->post();
		if($post){
			if($model->load($post) && $model->save(1)){
				Yii::$app->session->setFlash('success',Yii::t('profile',"YOU_DATA_UPDATED_SUCCESSFULL"));
				return $this->redirect(["profile/index"]);
			}else{
				Yii::$app->session->setFlash('danger',Yii::t('profile',"YOU_DATA_DID_N0T_UPDAT_SUCCESSFULL"));
			}
		}

		return $this->render("form",["model"=>$model]);
	}


	public function actionAddPhone(){

    	if(Yii::$app->request->post() || Yii::$app->request->isAjax){

	        $model = new SignupForm;
	        $model->scenario = SignupForm::SCENARIO_CHANGE_PHONE;
	        
	        if(Yii::$app->request->post()){
	            if($model->load(Yii::$app->request->post()) && $model->validate()){
	                
	                if($model->confirmNewPhone()){
	                    Yii::$app->session->setFlash('success','На ваш номер телефона было отправлено смс сообщение с кодом подтверждения!');
	                }else{
	                    Yii::$app->session->setFlash('danger','Введен некорректный номер телефона!');
	                }
	            }else{
	                Yii::$app->session->setFlash('danger','Введен некорректный номер телефона!');
	            }
	            return $this->redirect(["profile/index"]);
	        }
	        return $this->renderAjax("addPhone",['model'=>$model]);
        }else{
        	return $this->redirect(["profile/index"]);
        }
    }





    public function actionAddEmail(){

    	if(Yii::$app->request->isAjax){

	        $model = new SignupForm;
	        $model->scenario = SignupForm::SCENARIO_CHANGE_EMAIL;
	        
	        if(Yii::$app->request->post()){
	            if($model->load(Yii::$app->request->post()) && $model->validate()){
	                
	                if($model->confirmNewEmail()){
	                    Yii::$app->session->setFlash('success','На вашу почту было отправлено письмо для подтверждения электронного адреса!');
	                }else{
	                    Yii::$app->session->setFlash('danger','Введен некорректный E-mail адрес!');
	                }

	            }else{
	                Yii::$app->session->setFlash('danger','Введен некорректный E-mail адрес!');
	            }
	            return $this->redirect(["profile/index"]);
	        }
	        return $this->renderAjax("addEmail",['model'=>$model]);
        }else{
        	return $this->redirect(["profile/index"]);
        }
    }



    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionSendConfirmPhone($p)
    {   
        if(!$p || $p == null)
            return $this->redirect(["site/login"]);

        $user = User::findByLogin($p);

        if(!$user || !isset($user->id))
            return $this->redirect(["site/login"]);



        if(ConfirmUser::confirmPhone($user)){
            Yii::$app->session->setFlash('success','Инструкция подтверждения учетной записи отправлена вам на телефон. Проверьте пожалуйста сообщения на вашем телефоне.');
        }

        return $this->redirect(["profile/index"]);
    }





    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionSendConfirmEmail($e)
    {
        if(!$e || $e == null)
            return $this->redirect(["site/login"]);

        $user = User::findByLogin($e);

        if(!$user || !isset($user->id))
            return $this->redirect(["site/login"]);



        if(ConfirmUser::confirmEmail($user)){
            Yii::$app->session->setFlash('success','Инструкция подтверждения учетной записи отправлена вам электронную почту. Проверьте пожалуйста свою почту.');
        }

        return $this->redirect(["profile/index"]);
    }

}
?>