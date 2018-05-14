<?php

namespace api\models\methods;

use Yii;
use common\base\Model;
use api\models\{Request};
use api\exceptions\ApiException;

class Method  extends Model {

	protected $tag = "api";
	
	const SESSION_START = 1;
	const SESSION_STOP  = 2;

	public static function getMethodByType($type){
			
		switch ($type) {
			case Method::SESSION_START :
				return new MethodSessionStart();
				break;
			case Method::SESSION_STOP :
				return new MethodSessionStop();
				break;
			default:
				return null;
				break;
		}

	}



	public static function getRequests(){
		
		$rs = Request::find()->where(['completed'=>0,'result'=>0,'type'=>"GET"])->all();
		
		$responces = [];
		if(is_array($rs) && count($rs)){
			foreach ($rs as $key => $r) {
				array_push($responces, json_decode($r->params_out,true));
			}
		}

		return $responces;
		
	}

	public static function createMethodSessionStop($session){
		$method = self::getMethodByType(Request::GET_COST);
		return  $method->create($session);
	}


	public static function createMethodSessionStart($session){
		$method = self::getMethodByType(Request::PAY);
		return  $method->create($session);
	}
}
?>