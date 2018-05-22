<?php 
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use common\base\ActiveRecord;
use common\models\{Level};
use yii\db\Query;

class Lesson extends ActiveRecord
{

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lesson}}';
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


   



    public function getLevel(){
        return $this->hasOne(Level::className(),['id'=>'level']);
    }
}
?>