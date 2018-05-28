<?php

namespace common\enums;


class Token{


	/**
	* Type token for reset password
	*/
	const TYPE_PASSWORD = 1;



	/**
	* Type token for reset and confirmation email
	*/
	const TYPE_EMAIL = 2;



	/**
	* Token types array 
	*/
	protected static $tokens=[
		self::TYPE_PASSWORD,
		self::TYPE_EMAIL,
	];

	/**
	* @return array types token
	*/
	public static function getTokens(){
		return self::$tokens;
	} 
}
?>