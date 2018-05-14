<?php 
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use common\base\ActiveRecord;


class Properties extends ActiveRecord
{

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%properties}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['name','title'],'required'],
        	
        	[['name','title'],'string'],
        	
            ['name','match','pattern'=>'/^[aA-zZ][aA-zZ0-9_]{1,20}$/'],

            ['critical_down_time','integer'],
            [['critical_down_time'],'default', 'value' => 0],
        ];
    }


    public static function getStationProperties(){
        return self::find()->all();
    }


}
?>