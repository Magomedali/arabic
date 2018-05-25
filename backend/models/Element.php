<?php 
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;

use common\models\Element as cElement;


class Element extends cElement
{


	public function deleteElement(){
		
		if($this->type == self::TYPE_AUDIO){
			
		}elseif($this->type == self::TYPE_IMAGE){

		}elseif($this->type == self::TYPE_VIDEO){

		}

		return $this->delete();
	}

}

?>