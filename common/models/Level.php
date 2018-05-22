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
            [['stand_id','client_id'],'required'],
            ['start_time','default','value' => date("Y-m-d\TH:i:s",time())],
            ['start_time','required'],
            ['actual','default','value'=>1],
            [['isDeleted','accepted'],'default','value'=>0],
        ];
    }



    public function scenarios(){
    	return array_merge(parent::scenarios(),[

    	]);
    }


    // public function getStand(){
    //     return $this->hasOne(Stand::className(),['id'=>'stand_id']);
    // }

    // public function getStation(){
    //     return $this->stand->station;
    // }

    // public function getClient(){
    //     return $this->hasOne(User::className(),['id'=>'client_id']);
    // }


}
?>