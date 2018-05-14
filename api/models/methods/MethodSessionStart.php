<?php

namespace api\models\methods;

use Yii;

use api\models\{Request};
use yii\db\{Query};
use yii\base\Exception;
use api\exceptions\ApiException;
use common\models\Session;
class MethodSessionStart extends Method
{

	public $sessionId;
	public $clientName;
	public $stationCode;
	public $standNumber;

	public function rules()
    {
        return [
            [['sessionId','clientName','stationCode','standNumber'], 'required'],
            [['sessionId','stationCode','standNumber'],'integer'],
            [['clientName'],'string'],
        ];
    }



	public function complete($request,$result){

		Yii::info("Ответ о завершении выполнения метода 'SessionStart' создан!",$this->tag);
		Yii::info($result,$this->tag);

		if(!(int)$result['ok']){

			Yii::info("Ошибка при выплнении метода SessionStart на клиенте",$this->tag);
			$this->processError($request,$result);
			return false;
		}


		if(!isset($result['sessionId']) || !$result['sessionId']){
			Yii::info("Отсутствует параметр sessionId, выбрашено исключение ApiException",$this->tag);
			throw ApiException::generateNotFoundSessionId();
		}

		$sId = $result['sessionId'];
		$session = Session::findOne($sId);

		if(isset($session->id) && $session->id){

			if($session->accept()){

				$request->params_in = json_encode($result);
				$request->completed = 1;
				$request->result = 1;

				if(!$request->save()){
					Yii::info("Произошла ошибка при сохранении старта сессии",$this->tag);
					throw ApiException::generateErrorSaveRequestSessionStart();
				}
			}else{
				Yii::info("Произошла ошибка при сохранении подтверждения сессии, выбрашено исключение ApiException",$this->tag);
				throw ApiException::generateErrorSessionSaveAccept();
			}

		}else{
			Yii::info("Сессия не найдена, выбрашено исключение ApiException",$this->tag);
			throw ApiException::generateNotFoundSession();
		}

	}

	public function create($session){
		if(!$session) return false;


		if($this->load($session) && $this->validate()){
			$request = new Request;
			$request->date_init = date("Y-m-d\TH:i:s",time());
			$request->type = "GET";
			$request->request_type = Request::REQUESTS ."-". self::SESSION_START;
			
			$responce['id'] = Request::getNextIdentityId();
			$responce['method'] = 'session_start';
			$responce['params'] = $this->attributes;

			$request->params_out = json_encode($responce);
			
			if($request->save()){
				Yii::info("Запрос на выполнение метода 'SssionStart' создан!",$this->tag);
				return $responce;
			}

			throw new Exception("Error, didn`t save requests for API", 1);
			
		}else{
			Yii::info("Ошибка при валидации параметров метода!",$this->tag);
			Yii::info($this->getErrors(),$this->tag);
		}

		throw new Exception("Error, an error occured while validating data for session start", 1);


		return false;
	}





	public function processError($request,$errorInfo){


		Yii::info("Обработка ошибки",$this->tag);
		
		/**
		* Определить возможные ошибки на клиенте и их обработку
		*/

		$request->params_in = json_encode($errorInfo);
		$request->completed = 1;
		$request->result = 0;

		if(!$request->save()){
			Yii::info("Произошла ошибка при сохранении выполненного метода",$this->tag);
			throw ApiException::generateErrorSaveRequestSessionStop();
		}

		return true;
	}
	
}
?>