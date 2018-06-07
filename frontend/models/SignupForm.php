<?php
namespace frontend\models;

use Yii;
use common\base\Model;
use common\models\{User};
use frontend\models\{ConfirmUser};
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $sname;
    public $patronymic;
    public $email;
    public $phone;
    public $bdate;
    public $password;
    public $confirm_password;


    public $accept_condition;

    const SCENARIO_CHANGE_PHONE = "change-phone";
    const SCENARIO_CHANGE_EMAIL = "change-email";



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','sname','patronymic','email'], 'trim'],
            [['email','phone','password','confirm_password','accept_condition'], 'required'],
            
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким телефонным номером уже зарегистрирован!'],
            
            [['name','sname'],'string', 'min' => 2, 'max' => 255],

            ['accept_condition','in','range'=>[1],'message'=>''],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким E-mail уже зарегистрирован в системе'],

            ['phone', 'match', 'pattern' => Yii::$app->params['phone.pattern'], 'message' => 'Неправильный формат телефона 79250720927'],

            ['bdate','filter','filter'=>function($v){ return $v ? date('Y-m-d',strtotime($v)) : "";}],

            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают!" ]
        ];
    }

    


    public function scenarios(){
        return array_merge(parent::scenarios(),[
            self::SCENARIO_CHANGE_PHONE => ['phone'],
            self::SCENARIO_CHANGE_EMAIL => ['email']
        ]);
    }




    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->name = $this->name;
        $user->sname = $this->sname;
        $user->patronymic = $this->patronymic;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->bdate = $this->bdate;
        $user->email = $this->email;
        
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailConfirmToken();

        $pincode = \Yii::$app->security->generatePin(6);
        $user->setPhoneConfirmPinHash($pincode);

        if($user->save(1)){

            //Задать роль обычного пользователя
            //---------------------------------
            $user->assignRoleBase();

            ConfirmUser::sendMailConfirm($user);

            //ConfirmUser::sendPhoneSmsConfirm($user,$pincode);

            return $user;
        }

        return null;
    }




    public function confirmNewPhone(){

        $user = \Yii::$app->user->identity;
        
        if(isset($user->id)){
            
            $user->phone = $this->phone;
            $user->phone_confirmed = 0;
            
            $pincode = \Yii::$app->security->generatePin(6);
            $user->setPhoneConfirmPinHash($pincode);

            if($user->save(true)){
                ConfirmUser::sendPhoneSmsConfirm($user,$pincode);

                return $user;
            }
        }

        return false;
        
    }

    public function confirmNewEmail(){

        $user = \Yii::$app->user->identity;
        
        if(isset($user->id)){
            
            $user->email = $this->email;
            $user->email_confirmed = 0;
            $user->generateEmailConfirmToken();

            if($user->save(true)){
                
                ConfirmUser::sendMailConfirm($user);

                return $user;
            }
        }

        return false;
        
    }
}
