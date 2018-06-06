<?php 
namespace common\models;

use Yii;
use yii\base\{Exception,NotSupportedException};
use common\base\ActiveRecord;
use common\models\{Lesson,Level};

class LearningProcess extends ActiveRecord
{


	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%learning_process}}';
    }


   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','lesson_id'],'required']
        ];
    }


    
}
?>