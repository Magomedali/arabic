<?php

namespace testunit\unit;

use common\models\User;
use Yii;
//use PHPUnit\DbUnit\TestCase;
use PHPUnit\Framework\TestCase;

class UserSaveTest extends TestCase{
	
	public $testUserData = array(
		"name"=>"user",
		"sname"=>"userian",
		"patronymic"=>"userovich",
		'email'=>"user@mail.ru",
		"phone"=>"79845874555",
		"auth_key"=>'12341235151345345',
		"password_hash"=>'12341235151345345',
	);

	// public function getConnection(){
		
	// 	$pdo  = new \PDO($GLOBALS['DB_DSN'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASSWORD']);

	// 	return $this->createDefaultDBConnection($pdo,$GLOBALS['DB_NAME']);
	// }


	// public function getDataSet(){
		
		
	// 	return $this->createXMLDataSet(dirname(__FILE__).'/../_data/users.xml');
	// } 

	public function preparationDB(){

		$c = Yii::$app->db->createCommand();

		$c->dropForeignKey('fk-user-version_id',User::tableName())->execute();
		$c->dropForeignKey('fk-user_history-user_id',User::resourceTableName())->execute();
		$c->dropForeignKey('fk-user_history-entity_id',User::resourceTableName())->execute();

		User::deleteAll();
		User::clearHistories();
		
		$c->addForeignKey('fk-user-version_id', User::tableName(), 'version_id', User::resourceTableName(), 'id')->execute();
		$c->addForeignKey('fk-user_history-user_id', User::resourceTableName(), 'user_id', User::tableName(), 'id')->execute();
		$c->addForeignKey('fk-user_history-entity_id', User::resourceTableName(), 'entity_id', User::tableName(), 'id')->execute();
		
		
	}

	public function setUp(){
		parent::setUp();

		$this->preparationDB();

		$user = new User($this->testUserData);
		if($user->validate()){
			$user->save(1);
		}
		
		
	}


	protected function tearDown(){
		
	}

	
	/**
	* Провера валидации уникальных полей в бд
	*/
	public function testValidateExistedValues(){

		$user = new User([
			'email'=>$this->testUserData['email'],
			'phone'=>$this->testUserData['phone']
		]);

		$this->assertFalse($user->validate()," model is not valid");
		$this->assertArrayHasKey('email',$user->getErrors()," check existed email error");
		$this->assertArrayHasKey('phone',$user->getErrors()," check existed phone error");
	}



	/**
	* Провера поиска пользователя по email и phone в качестве логина.
	*/
	public function testFindUserByLogin(){

		$u = User::findByLogin($this->testUserData['email']);
		$this->assertTrue(isset($u['id']) && $u['id']," user not found by email");

		$u2 = User::findByLogin($this->testUserData['phone']);
		$this->assertTrue(isset($u2['id']) && $u2['id']," user not found by email");
	}


	/**
	* Провера сохранении и получении версии.
	* @depends testFindUserByLogin
	*/
	public function testExistVersion(){
		
		$user = User::findByLogin($this->testUserData['email']);
		$v = $user->getCurrentVersion();
		$this->assertTrue(isset($v['version']) && (int)$v['version'] >= 1,"check version story");
	}


	


	







}

?>