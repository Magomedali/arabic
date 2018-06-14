<?php
namespace frontend\models;

use Yii;
use common\models\User;
use frontend\models\SignupForm;
use yii\base\InvalidParamException;
use common\base\Model;

class ConfirmUser extends Model{


	protected $_user;

	public function setUser(User $user){
    	$this->_user = $user;
    }






	/**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public static function createForEmail($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Email confirm token cannot be blank.');
        }
        
        $confirm = new \frontend\models\ConfirmUserEmail($config);

        $user = User::findByEmailConfirmToken($token);
        
        if (!$user) {
            throw new InvalidParamException('Wrong email confirm token.');
        }

        $confirm->setUser($user);

        return $confirm;
    }




    




    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public static function createForPhone($params)
    {
        if (empty($params['key']) || !is_string($params['key']) || empty($params['pincode']) || !is_string($params['pincode'])) {
            throw new InvalidParamException('Phone confirm token cannot be blank.');
        }
        
        $p = Yii::$app->params['phone.pattern'];
        $patternV = new \yii\validators\RegularExpressionValidator(['pattern'=>$p]);
            
        $key = trim(strip_tags($params['key']));
        if($patternV->validate($key)){
            $user = User::findOne(['phone' => $key, 'status' => User::STATUS_ACTIVE]); 
        }else{
        	throw new InvalidParamException('Wrong phone confirm token.');
        }

        $pin = strip_tags($params['pincode']);
        if (!$user && !$user->validatePin($pin)) {
            throw new InvalidParamException('Wrong phone confirm token.');
        }

        $confirm = new \frontend\models\ConfirmUserPhone([]);
        $confirm->setUser($user);

        return $confirm;
    }








	public static function confirmPhone(User $user){

		if(!isset($user->id)) return null;

		if((int)$user->phone_confirmed) return true;

		$pincode = \Yii::$app->security->generatePin(6);
		$user->setPhoneConfirmPinHash($pincode);

		if($user->save(true)){
			return self::sendPhoneSmsConfirm($user,$pincode);
		}

		return false;
	}





	public static function confirmEmail(User $user){

		if(!isset($user->id)) return null;

		if((int)$user->phone_confirmed) return true;

		$user->generateEmailConfirmToken();

		if($user->save(true)){
			return self::sendMailConfirm($user);
		}

		return false;
	}






	public static function sendPhoneSmsConfirm($user,$pincode){
        
        if(!isset($user->id)) return null;

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'confirmPhone'],
                ['user' => $user,'pincode'=>$pincode]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('site',Yii::$app->name) . ' robot'])
            ->setTo($user->email)
            ->setSubject('Confirm phone profile in bicyclepark ' . Yii::t('site',Yii::$app->name))
            ->send();

        
    }







    public static function sendMailConfirm($user){

        if(!isset($user->id)) return null;

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'confirmEmail'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('site',Yii::$app->name) . ' robot'])
            ->setTo($user->email)
            ->setSubject('Confirm profile in arabic course ' . Yii::t('site',Yii::$app->name))
            ->send();

    }


}


?>