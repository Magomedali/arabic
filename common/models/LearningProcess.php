<?php 
namespace common\models;

use Yii;
use yii\base\{Exception,NotSupportedException};
use common\base\ActiveRecord;
use common\models\{Lesson,Level};

class LearningProcess extends ActiveRecord
{

    const TYPE_EVENT_BEGIN = 1;
    const TYPE_EVENT_END = 2;

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
            [['user_id','lesson_id'],'required'],
            ['block_id','integer'],
            ['type_event','default','value'=>self::TYPE_EVENT_BEGIN],
        ];
    }


    
}
?>