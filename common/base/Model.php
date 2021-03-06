<?php

namespace common\base;


class Model extends \yii\base\Model{


	/**
    * @param @attr = attribute name
    * @return translate attribute labels
    */
    public function getAttributeLabel($attr){
        $dic = (new \ReflectionClass($this))->getShortName();
        $dic = strtolower($dic);
        return \Yii::t($dic,$attr);
    }

    

    public function getAttributeHint($attr)
    {	
    	$dic = (new \ReflectionClass($this))->getShortName();
        $hints = $this->attributeHints();
        
        $dic = strtolower($dic);
        $hint = $attr."_hint";
        $lang_hint = \Yii::t($dic,$hint);
        $hint = $hint === $lang_hint ? "" : $lang_hint;
        
        return isset($hints[$attr]) ? $hints[$attr] : $hint;
    }

}

?>