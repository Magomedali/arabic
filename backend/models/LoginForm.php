<?php
namespace backend\models;

use Yii;

class LoginForm extends \common\base\Model{

    public $email;

    public $password;

    public $rememberMe;


    protected $_user;

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],

            ['email','email'],

            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],

            
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
            if (!$user || !$user->validatePassword($this->password) || !$user->canGetIn()) {
                $this->addError($attribute, 'Incorrect login or password.');
            }else{
                $this->_user = $user;
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
            $this->_user = User::findByLogin($this->email);
        }

        return $this->_user;
    }
}


?>