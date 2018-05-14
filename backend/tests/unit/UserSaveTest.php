<?php

namespace frontend\tests\unit;

use common\models\User;

class UserSaveTest extends \Codeception\Test\Unit{
	
	protected $tester;
	 
	public function _before(){
		

		User::deleteAll();


		\Yii::$app->db->createCommand()->insert(User::tableName(),[
			'username'=>'user',
			'email'=>'user@mail.ru',
			'password_hash'=>'123456',
			'auth_key'=>'12341235151345345',
			'updated_at'=>time(),
			'created_at'=>time()
		])->execute();
	}

	
	public function testValidateExistedValues(){

		$user = new User([
			'username'=>'user',
			'email'=>'user@mail.ru'
		]);

		
		$this->assertFalse($user->validate()," model is not valid");
		$this->assertArrayHasKey('username',$user->getErrors()," check existed username error");
		$this->assertArrayHasKey('email',$user->getErrors()," check existed email error");
	}


	public function testSaveIntoDatabase(){

		$user = new User([
			'username'=>'TestU',
			'email'=>'test@mail.ru'
		]);

		$user->setPassword("123456");
        $user->generateAuthKey();

		
		$this->assertTrue($user->save(),"check save model");
	}




}

?>