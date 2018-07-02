<?php 
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use common\models\{Lesson as cLesson};


class Lesson extends cLesson
{

	
	public function addBlock($blockParams){
        $block = new Block;
        
        if(isset($blockParams['Block'])){

            $block->load($blockParams);
            $block->save();
            
            return $block;
        }

        return false;

    }


    public function delete(){

        $blocks = $this->getBlocks();
        foreach ($blocks as $key => $b) {
        
            if(!$b->deleteBlock()){
                return false;
            }
        
        }
        return parent::delete();
    }

}
?>