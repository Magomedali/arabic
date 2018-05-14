<?php

namespace api\models;

use Yii;
use yii\db\{Expression,Query,Command};
use yii\base\Exception;

use api\exceptions\ApiException;
use api\models\{BaseRequest};
use api\models\Methods\Method;


class Request extends BaseRequest{

	


	public function requests(){
		
		$responce = [];
		$responce['ok'] = true;
		$responce['requests'] = array();
		
		$req = Method::getRequests();
		if(is_array($req) && count($req)){
			$responce['requests'] = $req;
		}


		if(is_array($responce['requests']) && count($responce['requests'])){
			return $responce;
		}else{
			return [];
		}
	}


	public function complete(){
		//Задачи метода:
		/** 
		* 1) Проверить id, есть ли запрос под таким id и требует ли он ответа
		* 2) Если Запрос ждет ответа, разбираем параметр result
		* 3) Проверить наличие неинтегрированных сессии sessionError
		* 4) Неинтегрированные сессии отметить на не подтвержденные, и дать запросу статус warning{result = 0, complete = 1}
		* 5) Из запроса получить GUID или id сессий, которые были в запросе. Выделяем из них интегрированные и отмечаем как подтвержденные.
		* 6) Записываем ответ в запрос и сохраняем с завершением. 
		**/
		try{
			$answer = [];
			$id = (int)Yii::$app->request->post('id');

			$request = Request::findOne($id);

			if($id){
				if(isset($request->id) && $request->id === $id){
					
					$answer['ok'] = true;

					if($request->completed){
						Yii::info(" Запрос №".$id." ранее уже был обработан!",$this->tag);
						return $answer['ok'] = true;
					} 
					
					$result = Yii::$app->request->post('result');

					Yii::info("Тип запроса - ".$request->request_type,$this->tag);
					
					
					if(is_array($result) && isset($result['ok'])){

						$r_type = str_replace(Request::REQUESTS."-", "", $request->request_type);
						$method = Method::getMethodByType($r_type);
						
						$method->complete($request,$result);
						Yii::info("Выполнен!",$this->tag);

					}else{
						$answer['ok'] = false;
						$answer["errorName"] = "WrongResult";
						$answer["error"] ="result has wrong format";
						$answer["userMessage"] = "Отсутствует параметр `result`.`ok`";
					}
				}else{
					$answer['ok'] = false;
					$answer["errorName"] = "WrongIdentificator";
					$answer["error"] = "identificator #{$id} not founded!";
					$answer["userMessage"] = "Запрос с идентификатором №{$id} не найден!";
				}

			}else{
				$answer['ok'] = false;
				$answer["errorName"] = "IdentificatorEmpty";
				$answer["error"] = "not founded identificator";
				$answer["userMessage"] = "Отсутствует идентификатор запроса!";
			}
			

			Yii::info("Ответ от сервера клиенту:",$this->tag);
			Yii::info($answer,$this->tag);
			return $answer;

		}catch(ApiException $e){
			return $e->getAnswer();
		}catch(Exception $e){

			$answer['ok'] = false;
			$answer["errorName"] = "ServerError";
			$answer["error"] = "error on server";
			$answer["userMessage"] = "Ошибка на сервере";

			return $answer;
		}
	}

	public function state(){
		return ['ok'=>true];
	}
}
?>