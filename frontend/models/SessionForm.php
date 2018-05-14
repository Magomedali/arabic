<?php
namespace frontend\models;

use Yii;
use common\base\Model;
use common\models\{User,Stand,Session};
use frontend\models\{ConfirmUser};
/**
 * Signup form
 */
class SessionForm extends Model
{
    public $station_code;
    public $stand_number;


    private $_stand;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stand_number','station_code'], 'trim'],
            [['stand_number','station_code'], 'required'],
            [['stand_number','station_code'], 'integer'],
            ['stand_number', 'checkStand'],
        ];
    }



    //Проверяем свободна ли станция и стойка и можно ли начать сессию.
    public function checkStand($attribute,$params){

        if(!$this->hasErrors()){

            $user = Yii::$app->user->identity;
            $_stand = $this->getStand();

            if(!$user || !isset($user->id) || !$_stand || !isset($_stand->id)){
                
                $this->addError($attribute,Yii::t('sessionForm','CHECK_STAND_ERROR'));
           
            }
        }
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function start()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $stand = $this->getStand();
        
        if(isset($stand->id)){

            $session = new Session;
            $session->stand_id = $stand->id;
            $session->client_id = Yii::$app->user->identity->id;

            return $session->start();
        
        }else{
            $this->addError("station_code",Yii::t('sessionForm','STAND_NOT_FOUNDED'));
        }
        

        return false;
    }


    public function getStand(){
        if(!$this->_stand || !isset($this->_stand->id)){
            $this->_stand = Stand::checkFreeStand($this->station_code,$this->stand_number);
        }

        return $this->_stand;
    }

}
