<?php 
namespace common\models;

use Yii;
use yii\base\{Exception,NotSupportedException};
use common\base\ActiveRecord;
use common\models\{Lesson,Level,Block};

class Element extends ActiveRecord
{

    public $files;

	const TYPE_TEXT = 1;
	const TYPE_AUDIO = 2;
	const TYPE_IMAGE = 3;
	const TYPE_VIDEO = 4;




	public static $FOLDERS = [
		self::TYPE_AUDIO => "/audio/",
		self::TYPE_IMAGE => "/image/",
		self::TYPE_VIDEO => "/video/",
	];



	public static $TYPE_TITLES = [
		self::TYPE_TEXT => "TEXT",
		self::TYPE_AUDIO => "AUDIO",
		self::TYPE_IMAGE => "IMAGE",
		//self::TYPE_VIDEO => "video"
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
            ['content','string'],
            ['files','file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif', 'mp4','m4a','mpeg', 'mp3'],'checkExtensionByMimeType'=>false],
            ['isPublic','default','value' => true ],
            ['position','default','value' => 1 ]
        ];
    }





    public function scenarios(){
    	return array_merge(parent::scenarios(),[
            
    	]);
    }


   

    

    public function hasFile(){
        if($this->type == Element::TYPE_TEXT) return false;

        $filePath = Yii::getAlias('@files').self::$FOLDERS[$this->type];
        return $this->file_name && file_exists($filePath.$this->file_name);
    }


    public function getFile(){
        if($this->type == Element::TYPE_TEXT) return false;
        
        return   Yii::getAlias('@files_pub').self::$FOLDERS[$this->type].$this->file_name;
    }



    public function getBlockModel(){
        return $this->hasOne(Block::className(),['id'=>'block']);
    }


}
?>