<?php 
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use common\base\ActiveRecord;
use common\models\{User,Lesson};


class Level extends ActiveRecord
{

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%level}}';
    }


    



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','position'],'required'],
            ['position','unique'],
            ['position','integer'],
            ['desc','default','value'=>null],
            ['isPublic','default','value' => true ]
        ];
    }


    public function scenarios(){
    	return array_merge(parent::scenarios(),[

    	]);
    }


    public function getLessons(){
        return $this->hasMany(Lesson::className(),['level'=>'id']);
    }
}
?>