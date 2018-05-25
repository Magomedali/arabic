<?php 
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;

use common\models\Block as cBlock;
use common\models\Element;

class Block extends cBlock
{




	public function addElements($elements){


		if(count($elements)){
			$BlockElemenst = array();
			foreach ($elements as $key => $el) {
				
				if(isset($el['id']) && (int)$el['id']){
					$element =  Element::find()->where(['id'=>(int)$el['id'],'block'=>$this->id])->one();
					
					if(!isset($element->id)) continue;

					if($element->type != Element::TYPE_TEXT) continue;

				}else{
					$element = new Element;
					$el['block']=$this->id;
				}
				
				
				$data['Element'] = $el;

				$element->load($data);
				if(!$element->save()){
					$BlockElemenst[] = $element;
				}

				
			}

			return $BlockElemenst;
		}

		return false;
	}





	public function removeElements(){

		if($this->id){
			return Element::deleteAll(['block'=>$this->id]);
		}else{
			return false;
		}
	}




	public function deleteBlock(){
		$this->removeElements();
		$this->delete();
	}
}

?>