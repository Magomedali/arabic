<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\enums\Token;
/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    protected $unConfirmedEmail = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
            ['email','checkConfirmEmail']
        ];
    }


    public function checkConfirmEmail($attribute,$params){

        if(!$this->hasErrors()){
            $user = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'email' => $this->email,
            ]);

            if(!$user || !isset($user->email_confirmed) || !(int)$user->email_confirmed){
                $this->unConfirmedEmail = true;
                $this->addError($attribute,"Указаный почтовый адрес не подтвержден пользователем!");
            }
        }

    }


    public function getUnConfirmedEmail(){
        return $this->unConfirmedEmail;
    }


    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isTokenValid(Token::TYPE_PASSWORD,$user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
