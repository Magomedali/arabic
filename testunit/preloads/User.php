<?php

namespace testunit\preloads;

use yii\web\User as yUser;

class User extends yUser{

	
	public function getIdentity($autoRenew = true){
		return null;
	}
}
?>