<?php
namespace frontend\models;

use Yii;
use common\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user;

    protected $error_emailConfirm = false;
    protected $error_phoneConfirm = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login', 'password'], 'required'],

            ['login','checkConfirm'],

            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],

            
        ];
    }



    public function attributeHints(){
        return [
            'login'=>'user@mail.ru or +7925072092'
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect login or password.');
            }else{
                $this->_user = $user;
            }
        }
    }




    public function checkConfirm($attribute, $params){
 
        $emailV = new \yii\validators\EmailValidator();

        if($emailV->validate($this->login)){
            //Проверить Подтвержден ли e-mail
            $user = $this->getUser();
            if($user && !(int)$user->email_confirmed){
                $this->addError($attribute, 'Your e-mail is unconfirmed!');
                $this->error_emailConfirm = true;
            }
            
        }else{

            $p = Yii::$app->params['phone.pattern'];
            $patternV = new \yii\validators\RegularExpressionValidator(['pattern'=>$p]);

            if($patternV->validate($this->login)){
                //Проверить Подтвержден ли e-mail
                $user = $this->getUser();
                if($user && !(int)$user->phone_confirmed){
                    $this->addError($attribute, 'Your phone is unconfirmed!');
                    $this->error_phoneConfirm = true;
                }

            }else{
                $this->addError($attribute, 'Your e-mail or phone is incorrect!');
            }
        }
    }



    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {   

        /**
        * Проверить подтвержден ли email или телефон
        * 
        */

        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }




    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByLogin($this->login);
        }

        return $this->_user;
    }



    public function unConfirmedEmail(){
        return $this->error_emailConfirm;
    }


    public function unConfirmedPhone(){
        return $this->error_phoneConfirm;
    }


}
