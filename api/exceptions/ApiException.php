<?php

namespace api\exceptions;

class ApiException extends \yii\base\Exception{

	public $error = "";
	public $errorName = "";
	public $userMessage = "";


	public function __construct($message, $errorInfo = [], $code = 0, \Exception $previous = null)
    {
        $this->errorName = isset($errorInfo['errorName']) ? $errorInfo['errorName'] : "ApiServerError" ;
        $this->error = isset($errorInfo['error']) ? $errorInfo['error'] : "error on server" ;
        $this->userMessage = isset($errorInfo['userMessage']) ?$errorInfo['userMessage'] : "Не известная ошибка!" ;

        parent::__construct($message, $code, $previous);
    }


    public function getAnswer(){
    	return [
    		'ok'=>false,
    		'error'=>$this->error,
    		'errorName'=>$this->errorName,
    		'userMessage'=>$this->userMessage,
    	];
    }

	public function getName(){
        return 'REST API Exception';
    }



    /**
    *  Исключение выбрасывается, когда в параметрах запроса не обнаружен параметр sessionId
    *
    */
    public static function generateNotFoundSessionId(){
    	return new  self("Отсутствует параметр sessionId",[
				"errorName"=>"errorSessionId",
				'error'=>'sessionId not found',
				'userMessage'=>'Отсутствует параметр sessionId'
			]);
    }


    /**
    *  Исключение выбрасывается, когда в системе не найдена сессия по параметру sessionId
    *
    */
    public static function generateNotFoundSession(){
    	return new  self("Сессия не найдена в системе",[
				"errorName"=>"errorSession",
				'error'=>'session not found',
				'userMessage'=>'Сессия не найдена в системе'
			]);
    }


    /**
    *  Исключение выбрасывается при возникновении ошибки во время сохранения изменении сессии
    *
    */
    public static function generateErrorSessionSaveAccept(){
    	return new  self("Произошла ошибка при сохранении подтверждения сессии",[
				"errorName"=>"errorSaveSessionAcceptResult",
				'error'=>'error occured while save session accept',
				'userMessage'=>'Произошла ошибка при сохранении подтверждения сессии'
			]);
    }



    /**
    *  Исключение выбрасывается при возникновении ошибки во время сохранения изменении сессии
    *
    */
    public static function generateErrorSessionSaveAcceptStop(){
        return new  self("Произошла ошибка при подтверждении остановки сессии",[
                "errorName"=>"errorSaveSessionAcceptStop",
                'error'=>'error occured while save session accept stop',
                'userMessage'=>'Произошла ошибка при подтверждении остановки сессии'
            ]);
    }




    /**
    *  Исключение выбрасывается при возникновении ошибки во время сохранения изменении сессии
    *
    */
    public static function generateErrorSaveRequest(){
    	return new  self("Произошла ошибка при сохранении выполненного метода",[
				"errorName"=>"errorSaveRequest",
				'error'=>'error occured while save completing request',
				'userMessage'=>'Произошла ошибка при сохранении выполненного метода'
			]);
    }

    /**
    *  Исключение выбрасывается при возникновении ошибки во время сохранения изменении сессии
    *
    */
    public static function generateErrorSaveRequestSessionStart(){
        return new  self("Произошла ошибка при сохранении старта сессии",[
                "errorName"=>"errorSaveRequestSessionStart",
                'error'=>'error occured while save completing request session start',
                'userMessage'=>'Произошла ошибка при сохранении старта сессии'
            ]);
    }



    /**
    *  Исключение выбрасывается при возникновении ошибки во время сохранения изменении сессии
    *
    */
    public static function generateErrorSaveRequestSessionStop(){
        return new  self("Произошла ошибка при сохранении остановки сессии",[
                "errorName"=>"errorSaveRequestSessionStop",
                'error'=>'error occured while save completing request session stop',
                'userMessage'=>'Произошла ошибка при сохранении остановки сессии'
            ]);
    }
    


    


}
?>