<?php

namespace frontend\models;


class ConfirmUserEmail extends \frontend\models\ConfirmUser{



	public function __construct($token, $config = [])
    {
        parent::__construct($config);
    }


	public function confirm(){
		

		$this->_user->email_confirmed = true;
		$this->_user->removeEmailConfirmToken();

		return $this->_user->save(false);
	}


}

?>