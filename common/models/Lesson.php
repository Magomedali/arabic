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
            [['level','number','title'],'required'],
            [['number','level'],'integer'],
            ['desc','default','value'=>null],
            ['isPublic','default','value' => true ],
            ['number','checkExistsLesson']
        ];
    }



    public function scenarios(){
    	return array_merge(parent::scenarios(),[

    	]);
    }


   
    public function checkExistsLesson($attribute,$params){

        if(!$this->hasErrors()){

            $lesson = self::findOne(['level'=>$this->level,'number'=>$this->number]);
            if(isset($lesson->id)){
                $this->addError($attribute,Yii::t('level','CHECK_EXISTS_LESSON_ERROR'));
            }
        }
    }


    public function getLevel(){
        return $this->hasOne(Level::className(),['id'=>'level']);
    }
}
?>