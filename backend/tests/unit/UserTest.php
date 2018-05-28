<?php

namespace frontend\tests\unit;

use common\models\User;

class UserTest extends \Codeception\Test\Unit{
	

	protected $tester;

	public function testValidateEmptyValues(){
		$user = new User();

		$this->assertFalse($user->validate(),'Validate empty email');
		$this->assertArrayHasKey('username',$user->getErrors(),'check empty username error');
		$this->assertArrayHasKey('email',$user->getErrors(),'check empty email error');
	}


	public function testValidateWrongValues(){
		$user = new User();

		$user->email = "wrong_email";
		$user->username = "asfasdfasdf23faswfasf3afasdf";

		$this->assertFalse($user->validate(),"validate incorrect username and email");
		$this->assertArrayHasKey('email',$user->getErrors(),"check incorrect email");
		$this->assertArrayHasKey('username',$user->getErrors(),"check incorrect username");
	}

	public function testValidateCorrectValues(){
		$user = new User();

		$user->email = "mail@mail.ru";
		$user->username = "asfasd";

		$this->assertTrue($user->validate(),"validate incorrect username and email");
		
	}

}

?>