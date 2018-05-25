<?php 
namespace common\models;

use Yii;
use yii\base\{Exception,NotSupportedException};
use common\base\ActiveRecord;
use common\models\{Lesson,Level,Block};

class Element extends ActiveRecord
{



	const TYPE_TEXT = 1;
	const TYPE_AUDIO = 2;
	const TYPE_IMAGE = 3;
	const TYPE_VIDEO = 4;




	public static $FOLDERS = [
		self::TYPE_AUDIO => "audio",
		self::TYPE_IMAGE => "image",
		self::TYPE_VIDEO => "video",
	];



	public static $TYPE_TITLES = [
		self::TYPE_TEXT => "text",
		self::TYPE_AUDIO => "audio",
		self::TYPE_IMAGE => "image",
		self::TYPE_VIDEO => "video"
	];







	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%element}}';
    }




   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['block','type'],'required'],
            [['block','position','type'],'integer'],
            ['content','safe'],
            ['isPublic','default','value' => true ],
            ['position','default','value' => 1 ]
        ];
    }





    public function scenarios(){
    	return array_merge(parent::scenarios(),[
            
    	]);
    }





    public function getBlockModel(){
        return $this->hasOne(Block::className(),['id'=>'block']);
    }

}
?>