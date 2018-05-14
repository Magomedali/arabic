<?php 
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use common\base\ActiveRecordVersionable;


class PropertiesValue extends ActiveRecordVersionable
{



	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%properties_value}}';
    }



    public static function versionableAttributes(){
        return [
            'station_id',
            'property_id',
            'value',
            'isActive',
        ];
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['station_id','property_id'],'required'],
        	
        	['value','string'],
        ];
    }



    public static function getStationValues($station){
        if($station)
            return self::find()->where(['station_id'=>$station])->all();

        return false;
    }
}
?>