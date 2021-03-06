<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\{BadRequestHttpException,Controller};
use yii\filters\{VerbFilter,AccessControl};
use common\models\{User,Level};
use frontend\models\{LoginForm,SignupForm,ConfirmUser,ResetPasswordForm,PasswordResetRequestForm};



/**
 * Site controller
 */
class SiteController extends Controller
{





    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }





    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex(){   
        

        $levels = Level::find()->orderBy(['position'=>SORT_DESC])->all();

        return $this->render('index',['levels'=>$levels,'signUpModel'=>new SignupForm()]);
    }






    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }





    




    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    

    

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                return $this->render('successSignup', [
                    'model' => $user,
                ]);
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }





    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }





    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }







    public function actionConfirmEmail($token){

        try {
            $model = ConfirmUser::createForEmail($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if($model->confirm()){
            Yii::$app->session->setFlash('success','Ваш адрес электронной почты подтвержден, теперь вы можете заходить в личный кабинет используя ваш E-mail');
        }

        return $this->redirect(["site/login"]);
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

    // public function actionConfirmPhone(){
        
    //     $get = Yii::$app->request->get();

    //     if(isset($get['pincode']) && isset($get['key'])){
    //         try {
    //             $model = ConfirmUser::createForPhone($get);
    //         } catch (InvalidParamException $e) {
    //             throw new BadRequestHttpException($e->getMessage());
    //         }

    //         if($model->confirm()){
    //             Yii::$app->session->setFlash('success','Ваш номер телефона подтвержден, теперь вы можете заходить в личный кабинет используя ваш номер');
    //         }
    //     }

    //     return $this->redirect(["site/login"]);

    // }

}
