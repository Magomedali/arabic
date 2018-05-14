<?php

namespace backend\modules\users\models;


use yii\base\Object;

class User extends Object
{
	private static $_user;

	public function __construct(){

		$UserModel = get_class(\Yii::$app->user->identity);
		
		self::$_user = new $UserModel;
		
	} 	
	
	public static function getUser(){
		$UserModel = get_class(\Yii::$app->user->identity);
		return new $UserModel;
	}

	public static function getStatusArray(){
		$UserModel = get_class(\Yii::$app->user->identity);
		
		$user = new $UserModel;
		return [
			$user::STATUS_ACTIVE => 'Активный',
			$user::STATUS_DELETED => 'Не активный',
		];
	}
	
}
?>