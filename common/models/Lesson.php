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
            [['isPublic','showDesc'],'default','value' => true ],
            ['number','checkExistsLesson']
        ];
    }



    public function scenarios(){
    	return array_merge(parent::scenarios(),[
            self::SCENARIO_CREATE => ['number','title','desc','isPublic','showDesc','level']
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
        return Block::find()->where(['lesson'=>$this->id])->orderBy(['position'=>SORT_ASC])->all();
    }



    public function getPublicBlocks(){
        return Block::find()->where(['lesson'=>$this->id,'isPublic'=>true])->orderBy(['position'=>SORT_ASC])->all();
    }

    public function getBlockById($id){
        return Block::find()->where(['lesson'=>$this->id,'isPublic'=>true,'id'=>$id])->one();
    }
    

    public function getFirstBlock(){
        return Block::find()->where(['lesson'=>$this->id,'isPublic'=>true])->orderBy(['position'=>SORT_ASC])->one();
    }


    public function getFirstLesson(){
        return self::find()->where(['level'=>$this->level,'isPublic'=>true])->orderBy(['number'=>SORT_ASC])->one();
    }






    public function getLastLesson(){
        return self::find()->where(['level'=>$this->level,'isPublic'=>true])->orderBy(['number'=>SORT_DESC])->one();
    }

    public function getLastBlock(){
        return Block::find()->where(['lesson'=>$this->id,'isPublic'=>true])->orderBy(['position'=>SORT_DESC])->one();
    }




    public function isLast(){

        $ll = $this->lastLesson;
        if(isset($ll->id)){
            return $ll->id == $this->id;
        }

        return false;

    }






    public function isFirst(){
        $fl = $this->firstLesson;
        if(isset($fl->id)){
            return $fl->id == $this->id;
        }

        return false;
    }




    public function getNextLesson(){
        return self::find()->where(['level'=>$this->level,'isPublic'=>true])->andFilterWhere(['>','number',$this->number])->orderBy(['number'=>SORT_ASC])->one();
    }




    public function getPrevLesson(){
        return self::find()->where(['level'=>$this->level,'isPublic'=>true])->andFilterWhere(['<','number',$this->number])->orderBy(['number'=>SORT_DESC])->one();
    }



}
?>