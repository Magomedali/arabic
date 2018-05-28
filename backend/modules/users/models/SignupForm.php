<?php
namespace backend\modules\users\models;

use Yii;
use yii\base\Model;

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
    public $status;

    const SCENARIO_CHANGE_PHONE = "change-phone";
    const SCENARIO_CHANGE_EMAIL = "change-email";


    public $_user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','sname','patronymic','email'], 'trim'],
            [['name','sname','email','password','confirm_password'], 'required'],
            
            ['email', 'checkUniqueEmail'],
            
            [['name','sname'],'string', 'min' => 2, 'max' => 255],

            
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким E-mail уже зарегистрирован в системе'],

            

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



    public function checkUniqueEmail($attribute,$params){
        if (!$this->hasErrors()) {
            $user = User::getUser()->findOne(['email'=>$this->email]);
            if ($user && isset($user->id)) {
                $this->addError($attribute, 'Пользователь c таким E-mail адресом уже зарегистрирован!');
            }
        }
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
        
        $user = User::getUser();
        $user->name = $this->name;
        $user->sname = $this->sname;

        $user->email = $this->email;
        $user->email_confirmed = 1;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if($user->save(true)){

            //Задать роль обычного пользователя
            //---------------------------------
            $user->assignRoleBase();

            return $user;
        }

        return null;
    }

    

}
