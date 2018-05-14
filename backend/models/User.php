<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User as commonUser;

class User extends commonUser
{
    
	protected $_roles;

	public function canGetIn(){
		return 	$this->hasRole("superadmin") || 
				$this->hasRole("administrator") || 
				$this->hasRole("manager") || 
				$this->hasRole("dispatcher");
	}


	public function hasRole($role){
		if(!is_array($this->_roles))
			$this->_roles = \Yii::$app->authManager->getRolesByUser($this->id);
		
		return array_key_exists($role, $this->_roles);
	}

}
