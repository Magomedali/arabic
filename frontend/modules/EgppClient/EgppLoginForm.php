<?php
namespace frontend\modules\EgppClient;

use Yii;
use common\base\Model;
use common\models\User;
/**
 * Login form
 */
class EgppLoginForm extends Model
{
    public $email;
    public $password;

    public $rememberMe = true;

    private $_token;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],

            ['email','email'],

            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'safe'],

            ['email','checkToken']
            
        ];
    }
    



    public function addErrorEgpp()
    {
        $this->addError("email","Uncorrect email or password!");
    }





    public function checkToken($attr,$params)
    {
    	if(!$this->hasErrors()){
    		
            $token = $this->getToken();

            if(!$token){
                $this->addErrorEgpp();
            }
    	}
    }


    


    protected function getToken()
    {

        if(!$this->_token){
            $data = [
                'email'=>$this->email,
                'password'=>$this->password
            ];

            $this->_token = Egpp::getToken($data);
        }
        return $this->_token;
    }




    public function getEgppAccount()
    {
        $token = $this->getToken();

        if($token){

            $account = Egpp::getAccountByToken($token);
            if($account){
                return $account;
            }
            
        }
        
        $this->addErrorEgpp();
        return false;
    }




    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {   

        /**
        * Проверить подтвержден ли email или телефон
        * 
        */
        if ($this->validate()) {

            $account = $this->getEgppAccount();

            $user = $this->getUserByAccount($account);
            
            if($user){
                return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            }

        }
        

        return false;
    }




    protected function getUserByAccount($account)
    {   
        //$account['phones'][0] = "79884658257";
        if(!isset($account['user']) || !isset($account['user']['_id']) || !isset($account['phones'])) return false;

        $phone = isset($account['phones']) && is_array($account['phones']) && count($account['phones']) ? trim(strip_tags($account['phones'][0])) : "";

        $email = isset($account['user']['email']) ? trim(strip_tags($account['user']['email'])) : "";
        $egpp_id = isset($account['user']['_id']) ? $account['user']['_id'] : null;
        $u_p = User::findOne(['phone'=>$phone]);
        $u_e = User::findOne(['email'=>$email]);
        
        

        //Если пользователя с таким E-mail and phone не существует
        if(!$u_p && !$u_e){

            if($egpp_id){
                $u = User::findOne(['egpp_id'=>$egpp_id]);

                if(isset($u->id)){
                    return $u;
                }
            }

            return $this->addUserByAccount($account);
        
        }else{

            $egpp_id = (int)$account['user']['_id'];

            //Пользователь уже существует и email и телефон твкжу совпадают
            if(isset($u_e->id)){
                
                if((int)$u_e->egpp_id == $egpp_id){
                    
                    return $u_e;

                }elseif(isset($u_p->id)){
                    
                    if((int)$u_p->egpp_id == $egpp_id){
                        
                        return $u_p;

                    }elseif($u_p->id != $u_e->id){

                        $msg = "Авторизация прервана. В системе уже зарегистрированы два пользователя c электронным адресом ".$u_e->email." и с номером телефона ".$u_p->phone. " соответственно. Возможно вы регистрировали две учетных записи. Попробуйте воспользоваться одним из них, для входа в личный кабинет!";
                        $this->addError("email",$msg);
                        return false;
                    }
                
                }
                
                return $u_e;
                 
            }else{
                
                $this->addError("email","Произошла неизвестная ошибка!");
                
                return false;
            }

        }

    }






    protected function addUserByAccount($account)
    {


        if(!isset($account['user'])) return false;

        $user = new User;

        $dUser = $account['user'];
        $user->name = isset($dUser['firstName']) ? trim(strip_tags($dUser['firstName'])) : null;
        $user->sname = isset($dUser['lastName']) ? trim(strip_tags($dUser['lastName'])) : null;
        $user->patronymic = isset($dUser['middleName']) ? trim(strip_tags($dUser['middleName'])) : null;
        $user->email = isset($dUser['email']) ? trim(strip_tags($dUser['email'])) : null;
        $user->email_confirmed = true;
        $user->egpp_id = isset($dUser['_id']) ? trim(strip_tags($dUser['_id'])) : null;

        $user->phone = isset($account['phones']) && is_array($account['phones']) && count($account['phones']) ? trim(strip_tags($account['phones'][0])) : null;
        
        $user->phone_confirmed = $user->phone ? true : false;

        $user->status = User::STATUS_ACTIVE;

        $user->setPassword($this->password);
        
        $user->generateAuthKey();

        if($user->validate() && $user->save(true)){
            //Дать роль пользователю
            $user->assignRoleBase();
            return $user;
        }
        return false;
    }



}
