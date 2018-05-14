<?php 
namespace common\models;

use Yii;
use yii\base\{Exception,NotSupportedException};
use common\base\ActiveRecordVersionable;


class Station extends ActiveRecordVersionable
{

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%station}}';
    }


    public static function versionableAttributes(){
        return [
            'code',
            'longitude',
            'latitude',
            'ip',
            'address',
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



    public static function getMapStations(){

        try{
            $sql = "exec proc_getMapStations";
            return \Yii::$app->db->createCommand($sql)->queryAll();
        }catch(Exception $e){
            return [];
        }
        
    }
}
?>