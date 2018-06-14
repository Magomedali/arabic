<?php 
namespace common\models;

use Yii;
use yii\base\{Exception,NotSupportedException};
use common\base\ActiveRecord;
use common\models\{Lesson,Level};

class Block extends ActiveRecord
{

    const SCENARIO_CREATE = 'create';

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
            [['lesson','position'],'required'],
            [['lesson','position'],'integer'],

            [['isPublic','displayInline'],'default','value' => true ],
            ['position','checkExistsBlock']
        ];
    }



    public function scenarios(){
    	return array_merge(parent::scenarios(),[
            self::SCENARIO_CREATE => ['lesson','position','isPublic']
    	]);
    }

    public function checkExistsBlock($attribute,$params){

        if(!$this->hasErrors()){

            $block = self::findOne(['lesson'=>$this->lesson,'position'=>$this->position]);
            if(isset($block->id)){
                if(!isset($this->id) || $this->id != $block->id){
                    $this->addError($attribute,Yii::t('block','CHECK_EXISTS_BLOCK_ERROR'));
                }
            }
        }
    }


    public function getLessonModel(){
        return $this->hasOne(Lesson::className(),['id'=>'lesson']);
    }



    public function getElements(){
        return $this->hasMany(Element::className(),['block'=>'id']);
    }


    public function getPublicElements(){
        return Element::find()->where(['block'=>$this->id,'isPublic'=>1])->orderBy(['position'=>SORT_ASC])->all();
    }


}
?>
