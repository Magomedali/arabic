<?php 
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;

use common\models\Block as cBlock;
use backend\models\Element;
// use backend\helpers\UploadedFile;
use yii\web\UploadedFile;

class Block extends cBlock
{

	public function addElements($elements){

		$errorElements = array();

		$addedElements = array();

		

		if(count($elements)){
			foreach ($elements as $key => $data) {
				if(isset($data['id']) && (int)$data['id']){
					$element =  Element::find()->where(['id'=>(int)$data['id'],'block'=>$this->id])->one();
					
					if(!isset($element->id)) return false;
				
				}else{
					$element = new Element;
					$data['block']=$this->id;
				}
					
				$params['Element'] = $data;
                
				$element->load($params);	

				if($element->type != Element::TYPE_TEXT){

					
					$count = $key;
					$element->files = UploadedFile::getInstanceByName("Elements[$count][files]");
					
					
			        if($element->files && $element->validate()){
			        	$element->uploadFile();
			        }

			        //Добавляем для аудио иконку
			        if($element->type == Element::TYPE_AUDIO){
			        	$element->icon = UploadedFile::getInstanceByName("Elements[$count][icon]");

				        if($element->icon && $element->validate()){
				        	$element->uploadAudioIcon();
				        }
			        }
			    }

			    if(!$element->validate()){
			    	$errorElements[] = $element;
			    	continue;
			    }
			    $element->save();

			    $addedElements[] = $element;
			}

			return count($errorElements) ? $errorElements : true;
		}

		return false;
	}








	public function addElement($data){

		if(count($data)){

			if(isset($data['id']) && (int)$data['id']){
				$element =  Element::find()->where(['id'=>(int)$data['id'],'block'=>$this->id])->one();
				
				if(!isset($element->id)) return false;
			
			}else{
				$element = new Element;
				$data['block']=$this->id;
			}
				
			$params['Element'] = $data;
				
			$element->load($params);	

			if(!$element->validate()) return $element;

			if($element->type != Element::TYPE_TEXT){

				$element->files = UploadedFile::getInstance($element,'files');
		        if($element->files){
		        	$element->uploadFile();
		        }


		        //Добавляем для аудио иконку
		        if($element->type == Element::TYPE_AUDIO){
		        	$element->icon = UploadedFile::getInstance($element,'icon');
			        if($element->icon){
			        	$element->uploadAudioIcon();
			        }
		        }
		    }

		    $element->save();

			return $element;
		}

		return false;
	}





	public function removeElements(){

		if($this->id){
			$elements = Element::find()->where(['block'=>$this->id])->all();
			
			foreach ($elements as $e) {
				$e->deleteElement();
			}
			return true;
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