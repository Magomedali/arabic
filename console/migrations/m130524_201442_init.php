<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->null(),
            'sname' => $this->string()->null(),
            'patronymic' => $this->string(),

            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),

            'email' => $this->string()->notNull()->unique(),
            'email_token' => $this->string(),
            'email_confirmed'=>$this->boolean()->notNull()->defaultValue(0),

            'phone' => $this->string(),
            'phone_token' => $this->string(),
            'phone_confirmed'=>$this->boolean()->notNull()->defaultValue(0),

            'bdate'=>$this->date()->null(),
            'egpp_id'=>$this->integer()->null(),
            'isDeleted'=> $this->smallInteger()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'version_id'=> $this->integer()->null(),
            
        ], $tableOptions);

        $this->createTable('{{%user_history}}', [
            'id' => $this->primaryKey(),
            'entity_id' => $this->integer()->notNull(),
            'name' => $this->string()->null(),
            'sname' => $this->string()->null(),
            'patronymic' => $this->string(),

            'password_hash' => $this->string()->notNull(),

            'email' => $this->string()->notNull(),
            'email_confirmed'=>$this->boolean()->notNull()->defaultValue(0),

            'phone' => $this->string(),
            'phone_confirmed'=>$this->boolean()->notNull()->defaultValue(0),

            'isDelete'=> $this->smallInteger()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'user_id'=>$this->integer()->null(),
            'type_action'=>$this->string()->notNull()->defaultValue("created"),
            'version'=>$this->integer()->notNull()->defaultValue(1),
            'isDeleted'=>$this->smallInteger()->notNull()->defaultValue(0),
            
        ], $tableOptions);

        $this->addForeignKey('fk-user_history-entity_id', '{{%user_history}}', 'entity_id', 'user', 'id');

        $this->addForeignKey('fk-user_history-user_id', '{{%user_history}}', 'user_id', 'user', 'id');

        $this->addForeignKey('fk-user-version_id', '{{%user}}', 'version_id', 'user_history', 'id');

        $this->addData();
    }


    protected function addData(){

        
        $data = require(__DIR__."/../config/data.php");

        if(isset($data['user']) && is_array($data['user'])){
            foreach ($data['user'] as $key => $user) {
                
                $this->insert('user', [
                    'name' => $user['name'],
                    'sname' => $user['sname'],
                    'email' => $user['email'],
                    'status' => common\models\User::STATUS_ACTIVE,
                    'password_hash' => \Yii::$app->security->generatePasswordHash($user['password']),
                    'auth_key' => \Yii::$app->security->generateRandomString(),
                    'email_confirmed'=>1,
                    'phone_confirmed'=>0,
                ]);

            }
        }

    }

    public function down()
    {   
        $this->dropForeignKey('fk-user-version_id','{{%user}}');
        $this->dropTable('{{%user_history}}');
        $this->dropTable('{{%user}}');
    }
}
