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



    public function getFirstLevel(){
        return self::find()->orderBy(['position'=>SORT_ASC])->one();
    }



    public function getLastLevel(){
        return self::find()->orderBy(['position'=>SORT_DESC])->one();
    }



    public function getFirstLesson(){
        return Lesson::find()->where(['level'=>$this->id])->orderBy(['number'=>SORT_ASC])->one();
    }



    public function getLastLesson(){
        return Lesson::find()->where(['level'=>$this->id])->orderBy(['number'=>SORT_DESC])->one();
    }



    public function getNextLevel(){
        return self::find()->andFilterWhere(['>','position',$this->position])->orderBy(['position'=>SORT_ASC])->one();
    }




    public function getPrevLevel(){
        return self::find()->andFilterWhere(['<','position',$this->position])->orderBy(['position'=>SORT_DESC])->one();
    }

}
?>