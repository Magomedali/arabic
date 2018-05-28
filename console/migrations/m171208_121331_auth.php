<?php

use yii\db\Migration;

/**
 * Class m171208_121331_auth
 */
class m171208_121331_auth extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {   

        // $tableOptions = null;
        // if ($this->db->driverName === 'mysql') {
        //     $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        // }

        // $this->createTable('auth', [
        //     'id' => $this->primaryKey(),
        //     'user_id' => $this->integer()->notNull(),
        //     'source' => $this->string()->notNull(),
        //     'source_id' => $this->string()->notNull(),
        // ],$tableOptions);

        // $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        //$this->dropTable('auth');
    }
}
