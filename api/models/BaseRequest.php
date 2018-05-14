<?php

namespace api\models;

use Yii;
use yii\db\{ActiveRecord,Expression,Query,Command};
use yii\base\Exception;


class BaseRequest extends ActiveRecord{

    protected $tag = "api";
    
    const REQUESTS = 1;
    
    const SESSION_START = 2;

    const SESSION_END = 3;

    const SESSION_PAY = 4;


    public static $type_requests = [
        self::REQUESTS=>"REQUESTS",
        self::SESSION_START=>"SESSION_START",
        self::SESSION_END=>"SESSION_END",
        self::SESSION_PAY=>"SESSION_PAY"
    ];
    
    /**
    * Ошибки, которые могут возникнуть на стороне СПП, при которых нужно прекратить слять ответы на запросы сервера
    *   0 - пометить транзакцию как выполненную 
    *   1 - завершить транзакцию с ошибкой
    */
    public static $errorsStopSend = [
        "UnknownParkomatPaymentTypeError"=>0,
        "DuplicateExternalIdError"=>1,
        "ValidatorError"=>0
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_type','type','date_init'], 'required'],

            ['date_init','default','value'=>date("Y-m-d\TH:i:s",time())],
            
            [['completed','result'],'default','value'=>0],
            [['params_out','date_executed','params_in'],'safe'],
            
        ];
    }



    public static function model($className = __CLASS__){
        return parent::model($className);
    }



    public static function tableName(){
        return '{{%request}}';
    }





    public static function primaryKey(){
        return array('id');
    }




    public function attributeLabels(){
                return array(
                    'id'=>'ID',
                    'request_type'=>'Запрос',
                    'type'=>'Тип запроса',
                    'date_init'=>'Дата инициализации запроса',
                    'date_executed' => 'Дата выполнения',
                    'params_in'   => 'Входные параметры',
                    'params_out' => 'Выходные параметры',
                    'result'  => 'Результат',
                    'completed' => 'Выполнен',
                );
    }

   
    



    public static function getNextIdentityId(){

        switch (\Yii::$app->db->driverName) {
            case 'mysql':
                return self::getNextIdentityId_MYSQL();
                break;
            case 'mssql':
                return self::getNextIdentityId_MSSQL();
                break;
            case 'sqlsrv':
                return self::getNextIdentityId_MSSQL();
                break;
            case 'dblib':
                return self::getNextIdentityId_MSSQL();
                break;
            default:
                return false;
                break;
        }
    }

    public static function getNextIdentityId_MSSQL(){

        $sql = "exec getNextIdentityRequest";

        $res = Yii::$app->db->createCommand($sql)
            ->queryOne();

       
        if(isset($res['next'])){
            $i = (int)$res['next'];
            return  $i;
        }else{
            
            $sql = "SELECT TOP 1 [id] FROM ".self::tableName()." ORDER BY id DESC";
            $last_id = Yii::$app->db->createCommand($sql)
            ->queryScalar();
            
            return $last_id+1;
        }

    }

    public static function getNextIdentityId_MYSQL(){

        $sql = "SHOW TABLE STATUS WHERE name='".self::tableName()."'";

        $res = Yii::$app->db->createCommand($sql)
            ->queryOne();

       
        if(isset($res['Auto_increment'])){
            return (int)$res['Auto_increment'];
        }else{
            $sql = "SELECT `id` FROM ".self::tableName()." ORDER BY id DESC LIMIT 1";
            $last_id = Yii::$app->db->createCommand($sql)
            ->queryScalar();
            return $last_id+1;
        }

    }





    public function setParamIn($name,$value){

        $params_in = json_decode($this->params_in);
        if(is_object($params_in) && property_exists($params_in, $name)){

            $params_in->$name = $value;
            $params = [];
            foreach ($params_in as $key => $v) {
                $params[$key] = $v;
            }

            $this->params_in = json_encode($params);
            return $this->save();
            
        }
    }





    public function getParamIn($name,$array = false){

        $b = $array && 1;
        $params_in = json_decode($this->params_in,$b);
        
        if(is_object($params_in) && property_exists($params_in, $name)){
            return $params_in->$name;
        }elseif(is_array($params_in) && array_key_exists($name, $params_in)){
            return $params_in[$name];
        }
    }






    public function getParamOut($name,$array = false){
        
        $b = $array && 1;

        $params_out = json_decode($this->params_out,$b);
        if(is_object($params_out) && property_exists($params_out, $name)){
            return $params_out->$name;
        }elseif(is_array($params_out) && array_key_exists($name, $params_out)){
            return $params_out[$name];
        }
    }
}
?>