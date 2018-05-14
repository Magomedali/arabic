<?php

namespace api\modules\apiclient\models;

use yii\httpclient\Client;
use yii\httpclient\Response;

class Test extends \yii\base\BaseObject{

	
    public $host = "";

    public $completeServerAnsw = array();

    public function getRequests(){

    	$client = new Client();

    	$response = $client->createRequest()
    						->addHeaders([
    							'content-type' => 'application/json',
    						])
				    		->setMethod("get")
				    		->setUrl($this->host."requests")
				    		->send();

        if(self::responseIsOk($response)){
        	$response = json_decode($response->getContent(),true);
        	
        	return $response;
        }

		return false;
    }



    public function executeRequests($id = null,$ok = true){

        $reqs = $this->getRequests();

        if(isset($reqs['ok']) && $reqs['ok'] == 1 && isset($reqs['requests']) && is_array($reqs['requests'])){
            foreach ($reqs['requests'] as $key => $r) {
                
                if((int)$id){
                    //выполняем только один метод
                    if((int)$r['id'] == (int)$id){
                        $this->completeMethod($r,$ok);
                    }else{
                        continue;
                    }
                }else{
                    $this->completeMethod($r,$ok);
                }
            }
        }
    }



    public function completeMethod($m, $ok = true){

        if(isset($m['id']) && isset($m['method']) && isset($m['method'])){
            $data['id']=$m['id'];
            $data['result']=$m['params'];
            $data['result']['ok']= boolval($ok);

            $this->sendCompleted($data);
        }
    }


    public function sendCompleted($data){

        $client = new Client();

        $response = $client->createRequest()
                            ->addHeaders([
                                'content-type' => 'application/json',
                            ])
                            ->setMethod("PUT")
                            ->setUrl($this->host."requests/complete")
                            ->setData($data)
                            ->send();


        $this->completeServerAnsw[] = $response->getData();
    }






    public static function responseIsOk(Response $response){
    	return $response->getStatusCode() == 200 || $response->getStatusCode() == 204;
    }
}


?>