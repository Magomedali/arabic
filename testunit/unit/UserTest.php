<?php

namespace testunit\unit;

use Yii;
use common\models\User;
use common\enums\Token;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase{
	

	/**
	* Проверка версионируемых аттрибутов
	*/
	public function testVersionableAttributes(){
		
		$vAttrs = User::versionableAttributes();
		$this->assertTrue(in_array("name",$vAttrs),"Check versionable attribute name");
		$this->assertTrue(in_array("sname",$vAttrs),"Check versionable attribute sname");
		$this->assertTrue(in_array("patronymic",$vAttrs),"Check versionable attribute patronymic");
		$this->assertTrue(in_array("password_hash",$vAttrs),"Check versionable attribute password_hash");
		$this->assertTrue(in_array("email",$vAttrs),"Check versionable attribute email");
		$this->assertTrue(in_array("email_confirmed",$vAttrs),"Check versionable attribute email_confirmed");
		$this->assertTrue(in_array("phone",$vAttrs),"Check versionable attribute phone");
		$this->assertTrue(in_array("phone_confirmed",$vAttrs),"Check versionable attribute phone_confirmed");
		$this->assertTrue(in_array("status",$vAttrs),"Check versionable attribute status");
		$this->assertTrue(in_array("isDeleted",$vAttrs),"Check versionable attribute isDeleted");
	}



	public function testValidateEmptyValues(){
		
		$user = new User();

		$this->assertFalse($user->validate(),'Validate empty email');
		$this->assertArrayHasKey('email',$user->getErrors(),'check empty email error');
	}




	/**
	* Проверка неправильного формата данных email и phone
	*/
	public function testValidateWrongValues(){
		$user = new User();

		$user->email = "wrong_email";
		$user->phone = "8972635";
		$user->status = User::STATUS_ACTIVE + 1;
		
		$this->assertFalse($user->validate(),"validate incorrect type email and phone");
		$this->assertArrayHasKey('email',$user->getErrors(),"check incorrect email");
		$this->assertArrayHasKey('phone',$user->getErrors(),'check incorrect phone');
		$this->assertArrayHasKey('status',$user->getErrors(),'check incorrect status value');
	}




	/**
	* Проверка превышения длины свойств
	*/
	public function testValidateLengthData(){
		$user = new User();

		$user->patronymic = "adfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgsfasdfasdf23faswfasf3afasdfdfbdsfbdfbsdgghjghjgssssasdfsadfasdfasdfasdfasdfsaddsdfgdsfgsdfgdsfgdfgsdfgdsfgdsfgdfgdsfhjghjghjghjghjghjghjghjghjghjghjghjghjghjghj";
		$user->email = $user->patronymic."@mail.ru";
		$user->name = $user->patronymic;
		$user->sname = $user->patronymic;

		$this->assertFalse($user->validate(),"validate incorrect length sname,name,patronimyc,email.");
		$this->assertArrayHasKey('sname',$user->getErrors(),"check incorrect sname");
		$this->assertArrayHasKey('name',$user->getErrors(),"check incorrect name");
		$this->assertArrayHasKey('patronymic',$user->getErrors(),"check incorrect patronymic");
	}




	/**
	* Проверка превышения длины свойств
	*/
	public function testValidateCorrectValues(){
		$user = new User();

		$user->email = "mail@mail.ru";
		$user->name = "asfasd";
		$user->sname = "asfasd";
		$user->patronymic = "asfasd";
		$user->phone = "79250720927";
		$user->status = User::STATUS_ACTIVE;

		$this->assertTrue($user->validate(),"validate correct values");
	}



	/**
	* Проверка метода получения полного имени пользователя
	*/
	public function testContainsMethodGetFullName(){

		$name = "User";
		$sname = "Userian";
		$patronymic = "UserianPatr";
		$user = new User([
			'name'=>$name,
			'sname'=>$sname,
			'patronymic'=>$patronymic,
		]);

		$fullname = $user->getFullName();
		$this->assertContains($name,$fullname,"Validate fullname: name is not contained in fullname");
		$this->assertContains($sname,$fullname,"Validate fullname: sname is not contained in fullname");
		$this->assertContains($patronymic,$fullname,"Validate fullname: patronymic is not contained in fullname");


		$this->assertEquals($sname." ".$name." ".$patronymic,$fullname,"Validate fullname: formats is not equals");
	}



	/**
	* Проверка генерации и валидации аутентификационного ключа
	*/
	public function testValidAuthKey(){
		
		$user = new User();

		$user->generateAuthKey();

		$this->assertEquals($user->getAuthKey(),$user->auth_key,"Validate getAuthKey: auth keys are not equals!");
		$this->assertTrue($user->validateAuthKey($user->auth_key),"Validate auth_key: auth keys are not equals!");
	}



	/**
	* Проверка валидации неправильного аутентификационного ключа
	*/
	public function testWrongAuthKey(){
		$user = new User();

		$user->generateAuthKey();
		$akey = Yii::$app->security->generateRandomString();

		$this->assertFalse($user->validateAuthKey($akey),"Check wrong auth_keys: auth keys are equals!");
	}




	/**
	* Проверка метода хеширования пароля и проверка пароля на соответсвие.
	*/
	public function testValidateTruePassword(){
		$pass = "234561";

		$u = new User();
		$u->setPassword($pass);

		$this->assertTrue($u->validatePassword($pass),"Check password: password is not right");
	}




	/**
	* Проверка на соответствие хеша разных паролей
	*/
	public function testValidateWrongPassword(){
		$pass = "234561";

		$u = new User();
		$u->setPassword($pass);

		$this->assertFalse($u->validatePassword("234123"),"Check wrong password: password is right");
	}



	/**
	* Проверка метода хеширования пинкода и проверка пинкода на соответсвие.
	*/
	public function testValidateTruePin(){
		$pin = "234561";

		$u = new User();
		$u->setPhoneConfirmPinHash($pin);

		$this->assertTrue($u->validatePin($pin),"Check pincode: pincode is not right");
	}




	/**
	* Проверка на соответствие хеша разных паролей
	*/
	public function testValidateWrongPin(){
		$pin = "234561";

		$u = new User();
		$u->setPhoneConfirmPinHash($pin);

		$this->assertFalse($u->validatePin("234123"),"Check wrong pincode: pincode is right");
	}





	/**
	* Проверка генерации токенов
	*/
	public function testValidateGenerateTokens(){
		
		$u = new User();
		$u->generateEmailConfirmToken();
		$u->generatePasswordResetToken();
		$u->setPhoneConfirmPinHash("1234");

		$this->assertNotEmpty($u->phone_token,"Check generate phone token: phone token is empty");
		$this->assertNotEmpty($u->email_token,"Check generate email token: email token is empty");
		$this->assertNotEmpty($u->password_reset_token,"Check generate password reset token: password reset token is empty");

		$u->removeEmailConfirmToken();
		$u->removePhoneConfirmToken();
		$u->removePasswordResetToken();

		$this->assertEmpty($u->phone_token,"Check remove phone token: phone token is not empty");
		$this->assertEmpty($u->email_token,"Check remove email token: email token is not empty");
		$this->assertEmpty($u->password_reset_token,"Check remove password reset token: password reset token is not empty");
	}


	/**
	* Проверка валидации токена
	*/
	public function testValidateTokens(){
		$u = new User();
		$u->generateEmailConfirmToken();
		$u->generatePasswordResetToken();

		$this->assertTrue(User::isTokenValid(Token::TYPE_PASSWORD,$u->password_reset_token),"Validate password token: token is not valide!");
		$this->assertTrue(User::isTokenValid(Token::TYPE_EMAIL,$u->email_token),"Validate email token: token is not valide!");

		$this->assertFalse(User::isTokenValid(0,$u->email_token),"Validate token: token type is not defined");
	}





	/**
	* Проверка валидации просрочнных и нерпавильных токенов токена
	*/
	public function testValidateWrongTokens(){
		
		$exp = Yii::$app->params['user.tokenExpire'];
		$token = Yii::$app->security->generateRandomString() . '_' . (time() - (int)$exp - 1);
		
		$this->assertFalse(User::isTokenValid(Token::TYPE_EMAIL,$token),"Validate wrong token: token type is valid");
	}


	

}

?>