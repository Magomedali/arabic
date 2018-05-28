<?php

namespace common\helpers;

use yii\base\Security as yiiSecurity;

class Security extends yiiSecurity{


	public function generatePin($pin_lenght) { 
		// Маска 
		$pin_mask = "0123456789"; 
		// Длина маски 
		$range = 10; 
		$pin = '';  

		for($x = 0; $x < $pin_lenght; $x++){

		   	$pin.=$pin_mask[mt_rand(0,$range-1)];
		   	if($x == 0 && (int)$pin == 0){
		   	 	
		   		$zero = true;
		   	 	$x--;
		   	 	$pin = '';
			}
	    }  

	   	return $pin;  
	}

}
?>