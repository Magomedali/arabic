<?php 
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use common\base\ActiveRecordVersionable;
use common\models\{Session,Station};
use yii\db\Query;

class Stand extends ActiveRecordVersionable
{

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stand}}';
    }


    public static function versionableAttributes(){
        return [
            'number',
            'station_id',
            'isDeleted'
        ];
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }



    public function scenarios(){
    	return array_merge(parent::scenarios(),[

    	]);
    }


    /**
    * Условия свободной стойки для начала парковки по номеру станции и кода
    * 1) Наличие такой стойки на станции
    * 2) Не удалена, активна - isDeleted = 0
    * 3) В базе не должна быть сессия удовлетворяющая след условия
    * 3.1) сессия на текущую стойку
    * 3.2) время окончания равно NULL
    * 3.3) статус активности = 1
    */
    public static function checkFreeStand($station_number,$stand_number){
        if(!(int)$station_number || !(int)$stand_number) return false;

        return self::find()
                    ->innerJoin(['st'=>Station::tableName()],"st.id=stand.station_id")
                    //->innerJoin(['ss'=>Session::tableName(),"ss.stand_id=stand.id"])
                    ->where([
                        'stand.number'=>(int)$stand_number,
                        'stand.isDeleted'=>0,
                        'st.code'=>(int)$station_number,
                        'st.isDeleted'=>0
                    ])->
                    andWhere(
                        "not exists (
                            SELECT ss.id FROM ".Session::tableName()." ss 
                            WHERE ss.stand_id = stand.id AND ss.finish_time is NULL AND ss.actual = 1
                        )"
                    )
                    ->one();
    }



    public function getStation(){
        return $this->hasOne(Station::className(),['id'=>'station_id']);
    }
}
?>