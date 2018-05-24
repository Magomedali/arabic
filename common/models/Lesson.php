<?php 
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use common\base\ActiveRecord;
use backend\models\{Level,Block};
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


    const SCENARIO_CREATE = 'create';



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
            self::SCENARIO_CREATE => ['number','title','desc','isPublic','level']
    	]);
    }


   
    public function checkExistsLesson($attribute,$params){

        if(!$this->hasErrors()){

            $lesson = self::findOne(['level'=>$this->level,'number'=>$this->number]);

            

            if(isset($lesson->id)){
                if(!isset($this->id) || $this->id != $lesson->id){
                    $this->addError($attribute,Yii::t('level','CHECK_EXISTS_LESSON_ERROR'));
                }
            }
        }
    }


    public function getLevelModel(){
        return $this->hasOne(Level::className(),['id'=>'level']);
    }


    public function getBlocks(){
        return $this->hasMany(Block::className(),['lesson'=>'id']);
    }




    public function addBlock($blockParams){
        $block = new Block;
        
        if(isset($blockParams['Block'])){

            $block->load($blockParams);
            $block->save();
            
            return $block;
        }

        return false;

    }
}
?>