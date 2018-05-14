<?php

namespace frontend\modules\EgppClient;


use yii\httpclient\Client;
use yii\httpclient\Response;
class Egpp {

	public static $request_token = 'https://parking.fitdev.ru/auth/api/1.0/tokens';
    public static $request_account = 'https://parking.fitdev.ru/api/2.12/accounts/me';


    public static function getToken($data){
    	if(!is_array($data) || !count($data)) return false;

    	$client = new Client();

    	$response = $client->createRequest()
    						->addHeaders([
    							'content-type' => 'application/json',
    						])
				    		->setMethod("post")
				    		->setUrl(Egpp::$request_token)
				    		->setData($data)
				    		->send();

        if(self::responseIsOk($response)){
        	$response = json_decode($response->getContent(),true);
        	
        	if(isset($response['accessToken']) && isset($response['accessToken']['value']))
        		return $response['accessToken']['value'];
        
        }

		return false;
    }





    public static function getAccountByToken($token){
    	if(!$token) return false;

    	$client = new Client();

    	$response = $client->createRequest()
    						->addHeaders([
    							'content-type' => 'application/json',
    							'Authorization'=>"Bearer ".$token
    						])
				    		->setMethod("GET")
				    		->setUrl(Egpp::$request_account)
				    		->send();




		if(self::responseIsOk($response)){
        	$response = json_decode($response->getContent(),true);
        	
        	if(isset($response['account']))
        		return $response['account'];
        
        }

        return false;
    }





    public static function responseIsOk(Response $response){
    	return $response->getStatusCode() == 200 || $response->getStatusCode() == 204;
    }
}


?>