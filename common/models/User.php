<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use common\base\ActiveRecord;
use yii\web\IdentityInterface;
use common\enums\Token;
use common\models\LearningProcess;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    

    

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    

    // /**
    //  * @inheritdoc
    //  */
    // public function behaviors()
    // {
    //     return [
    //         TimestampBehavior::className(),
    //     ];
    // }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','sname','patronymic','email'],'string','max'=>255],
            
            [['email'],'required'],
            
            ['email','email'],

            [['email','phone'],'unique'],
            
            ['phone', 'match', 'pattern' => Yii::$app->params['phone.pattern'], 'message' => 'Неправильный формат телефона 79250720927' ],
            
            ['bdate','filter','filter'=>function($v){ return $v ? date('Y-m-d',strtotime($v)) : "";}],

            [['email_confirmed','phone_confirmed','isDeleted'],'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


    public function getFullName(){
        return $this->sname." ".$this->name." ".$this->patronymic;
    }




    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }



    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }



    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByLogin($login)
    {   
        $emailV = new \yii\validators\EmailValidator();

        if($emailV->validate($login)){
            return static::findOne(['email' => $login, 'status' => self::STATUS_ACTIVE]); 
        }else{

            $p = Yii::$app->params['phone.pattern'];
            $patternV = new \yii\validators\RegularExpressionValidator(['pattern'=>$p]);
            

            if($patternV->validate($login)){
               return static::findOne(['phone' => $login, 'status' => self::STATUS_ACTIVE]); 
            }
            
        }

        return null;
        
    }



    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isTokenValid(Token::TYPE_PASSWORD,$token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }



    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByEmailConfirmToken($token)
    {
        if (!static::isTokenValid(Token::TYPE_PASSWORD,$token)) {
            return null;
        }

        return static::findOne([
            'email_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }




    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isTokenValid($type,$token)
    {
        if (!in_array($type, Token::getTokens()) || empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.tokenExpire'];
        return $timestamp + $expire >= time();
    }




    




    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }




    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }




    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }




    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }




    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }




    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }




    /**
     * Generates email confirm token
     */
    public function generateEmailConfirmToken()
    {
        $this->email_token = Yii::$app->security->generateRandomString() . '_' . time();
    }




    /**
     * Validate phone pin hash
     */
    public function validatePin($pin)
    {
        return Yii::$app->security->validatePassword($pin, $this->phone_token);
    }





    /**
     * Generates phone confirm token
     */
    public function setPhoneConfirmPinHash($pin)
    {
        $this->phone_token = Yii::$app->security->generatePasswordHash($pin);
    }




    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }



    /**
     * Removes password reset token
     */
    public function removeEmailConfirmToken()
    {
        $this->email_token = null;
    }



    /**
     * Removes password reset token
     */
    public function removePhoneConfirmToken()
    {
        $this->phone_token = null;
    }



    public function assignRoleBase(){

        //$auth = Yii::$app->authManager;
        //$authorRole = $auth->getRole('base');
        //$auth->assign($authorRole, $this->getId());

        return $this;
    }





    public function getCurrentLesson(){
        $lesson = Lesson::find()
                    ->innerJoin(['lp'=>LearningProcess::tableName()]," lp.lesson_id = lesson.id")
                    ->innerJoin(['l'=>Level::tableName()]," l.id = lesson.level")
                    ->where(['lp.user_id'=>$this->id,'l.isPublic' => 1,'lesson.isPublic' => 1])->orderBy(['l.position'=>SORT_DESC,'lesson.number'=>SORT_DESC])
                    ->one();

        if(isset($lesson->id)) return $lesson;

        return false;
    }
    




    public function getMyNextLesson(){

        $prev = $this->getCurrentLesson();

        if(isset($prev->id)) return $prev->nextLesson;

        $level = new Level();
        $firstLevel = $level->firstLevel;

        if($firstLevel) return $firstLevel->firstLesson;
        return false;
    }


    


    public function lessonIsProcessed($l_id){
        $lp = LearningProcess::find()->where(['lesson_id'=>$l_id,'user_id'=>$this->id])->one();

        return isset($lp->id);
    }


    public function lessonBlockIsProcessed($l_id,$block_id){
        $lp = LearningProcess::find()->where(['lesson_id'=>$l_id,'user_id'=>$this->id,'block_id'=>$block_id])->one();

        return isset($lp->id);
    }





    public function processLesson(Lesson $lesson, Block $block){
        
        if(isset($lesson->id)){

            if($this->lessonBlockIsProcessed($lesson->id,$block->id)) return true;

            $lp = new LearningProcess;
            
            $lp->user_id = $this->id;
            $lp->lesson_id = $lesson->id;
            $lp->block_id = $block->id;
            $lp->type_event = LearningProcess::TYPE_EVENT_BEGIN;
            $lp->created = date("Y-m-d\TH:i:s",time());

            return $lp->save();

        }

        return false;
    }


    



}
