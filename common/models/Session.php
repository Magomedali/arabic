<?php 
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use common\base\ActiveRecordVersionable;
use common\models\{User,Stand,Station};

use api\models\Request;

class Session extends ActiveRecordVersionable
{

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%session}}';
    }


    public static function versionableAttributes(){
        return [
            'stand_id',
            'start_time',
            'finish_time',
            'client_id',
            'accepted',
            'actual',
            'isDeleted',
        ];
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stand_id','client_id'],'required'],
            ['start_time','default','value' => date("Y-m-d\TH:i:s",time())],
            ['start_time','required'],
            ['actual','default','value'=>1],
            [['isDeleted','accepted'],'default','value'=>0],
        ];
    }



    public function scenarios(){
    	return array_merge(parent::scenarios(),[

    	]);
    }


    public function getStand(){
        return $this->hasOne(Stand::className(),['id'=>'stand_id']);
    }

    public function getStation(){
        return $this->stand->station;
    }

    public function getClient(){
        return $this->hasOne(User::className(),['id'=>'client_id']);
    }


    public function getAttributesForApiStart(){

        if(!$this->id) return false;

        $data['sessionId'] = $this->id;
        $data['stationCode'] = $this->station->code;
        $data['standNumber'] = $this->stand->number;
        $data['clientName'] = $this->client->email;
        
        return $data;
    }


    public function getAttributesForApiStop(){

        if(!$this->id) return false;

        $data['sessionId'] = $this->id;
        $data['stationCode'] = $this->station->code;
        $data['standNumber'] = $this->stand->number;

        return $data;
    }

    /**
    * Создание сессии через сайт сайте
    */
    public function start(){
        if($this->validate() && $this->save(1)){
            
            //Создаем запрос Request который нужно 
            $method = new \api\models\methods\MethodSessionStart();
            
            $data['MethodSessionStart'] = $this->getAttributesForApiStart();
            
            $method->create($data);


            /*
            * Запросы для подтверждения нашало сессии
            *
            * Формирование API запроса 
            * Отправка запроса
            * Формирование СМС
            * Отправка СМС
            */

            return true;
        }else{
            return false;
        }
    }


    public function accept(){

        $this->accepted = true;
        if($this->save(1)){


            /** 
            * После подтверждения выполняем след действия
            * 1) Уведомляем клиента о начало парковки
            *
            */


            return true;
        }else{
            return false;
        }
    }



    public function sendRequestToStop(){

        $method = new \api\models\methods\MethodSessionStop();
        $data['MethodSessionStop'] = $this->getAttributesForApiStop();
        return $method->create($data);

    }


    public function stop(){
        return $this->sendRequestToStop();
    }




    public function acceptStop(){

        $this->finish_time = date("Y-m-d\TH:i:s",time());
        $this->actual = 0;
        
        if($this->save(1)){
            
            /*
            * Запросы для подтверждения нашало сессии
            *
            * Формирование API запроса 
            * Отправка запроса
            * Формирование СМС
            * Отправка СМС
            */

            return true;
        }else{
            return false;
        }
    }




    public function beforeSaveHistory($defaultAttr = array()){
        
        $this->start_time = date("Y-m-d\TH:i:s",strtotime($this->start_time));
        $this->finish_time = $this->finish_time ? date("Y-m-d\TH:i:s",strtotime($this->finish_time)) : NULL;
    }

}
?>