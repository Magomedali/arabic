<?php

namespace frontend\models;


class ConfirmUserPhone extends \frontend\models\ConfirmUser{


	public function __construct($token, $config = [])
    {
        parent::__construct($config);
    }


	public function confirm(){


		$this->_user->phone_confirmed = 1;
		$this->_user->removePhoneConfirmToken();

		return $this->_user->save(true,false);
	}
}

?>