<?php 
namespace common\models;

use Yii;
use yii\base\{Exception,NotSupportedException};
use common\base\ActiveRecord;
use common\models\{Lesson,Level};

class Block extends ActiveRecord
{

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%block}}';
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


    public function getLesson(){
        return $this->hasOne(Lesson::className(),['id'=>'lesson']);
    }


}
?>