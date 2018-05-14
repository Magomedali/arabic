<?php

use console\migrations\Migration;

use api\models\{Request};


class m180215_160102_api extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Request::tableName(),[
            'id' => $this->primaryKey(),
            'date_init'=> $this->datetime()->notNull(),
            'date_executed'=>  $this->datetime(50)->null(),
            'params_in'=>  $this->string(255)->null(),
            'params_out'=>  $this->string(255)->null(),
            'result'=> $this->smallInteger()->null()->defaultValue(0),
            'completed'=> $this->smallInteger()->null()->defaultValue(0),
            'request_type'=> $this->string()->notNull(),
            'type'=> $this->string()->notNull(),
            'session_id'=> $this->integer()->null(),
        ], $tableOptions);


        if ($this->isMSSQL()) {

            $table = Request::tableName();
            
            $sql = <<<SQL
                IF OBJECT_ID('dbo.getNextIdentityRequest') is not null
                    drop proc dbo.getNextIdentityRequest
        
SQL;
        $this->execute($sql);

            $sql = <<<SQL
            
            CREATE PROCEDURE getNextIdentityRequest
            AS
            declare @c int;
            BEGIN
            SELECT @c = COUNT([id])  FROM {$table};

            if(@c > 0)
                SELECT IDENT_CURRENT('request')+1 as 'next';
            else 
                SELECT 1 as 'next';
            END
SQL;
            $this->execute($sql);
        }
        

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {   

        $sql = <<<SQL
        IF OBJECT_ID('dbo.getNextIdentityRequest') is not null
            drop proc dbo.getNextIdentityRequest
        
SQL;
        $this->execute($sql);
        
        $this->dropTable(Request::tableName()); 
        

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180215_160102_api cannot be reverted.\n";

        return false;
    }
    */
}
