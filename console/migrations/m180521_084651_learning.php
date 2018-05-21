<?php

use yii\db\Migration;

/**
 * Class m180521_084651_learning
 */
class m180521_084651_learning extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //---------------------Таблица Level
        $this->createTable('{{%level}}', [
            'id'        => $this->primaryKey(),
            'title'     => $this->string()->notNull(),
            'desc'      => $this->text()->null(),
            'position'  => $this->smallInteger()->null()
        ], $tableOptions);

        $this->createIndex('level_position_unique_index',
                'level', 
                ['position'], 
                true);
        //------------------ Конец - Таблицы Level
        

        //---------------------Таблица lesson
        $this->createTable('{{%lesson}}', [
            'id'        => $this->primaryKey(),
            'level'     => $this->integer()->notNull(),
            'number'    => $this->integer()->notNull(),
            'title'     => $this->string()->notNull(),
            'desc'      =>$this->text()->null(),
        ], $tableOptions);

        $this->createIndex('lesson_number_unique_index',
                'lesson', 
                ['number'], 
                true);
        
        $this->addForeignKey('fk-lesson-level', '{{%lesson}}', 'level', 'level', 'id');
        //---------------------Конец таблицы lesson



        //---------------------Таблица block
        $this->createTable('{{%block}}', [
            'id'        => $this->primaryKey(),
            'lesson'     => $this->integer()->notNull(),
            'position'    => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('block_lesson_position_unique_index',
                'block', 
                ['position','lesson'], 
                true);
        
        $this->addForeignKey('fk-block-lesson', '{{%block}}', 'lesson', 'lesson', 'id');
        //---------------------Конец таблицы block


        //---------------------Таблица element
        $this->createTable('{{%element}}', [
            'id'            => $this->primaryKey(),
            'block'        => $this->integer()->notNull(),
            'type'      => $this->integer()->notNull(),
            'content'      => $this->text()->null(),
        ], $tableOptions);

        
        
        $this->addForeignKey('fk-element-block', '{{%element}}', 'block', 'block', 'id');
        //---------------------Конец таблицы element




        //---------------------Таблица learning_process
        $this->createTable('{{%learning_process}}', [
            'id'            => $this->primaryKey(),
            'user_id'        => $this->integer()->notNull(),
            'lesson_id'      => $this->integer()->notNull(),
            'block_id'      => $this->integer()->null(),
            'created'      => $this->datetime()->null(),
        ], $tableOptions);

        
        
        $this->addForeignKey('fk-learning_process-user_id', '{{%learning_process}}', 'user_id', 'user', 'id');
        $this->addForeignKey('fk-learning_process-block_id', '{{%learning_process}}', 'block_id', 'block', 'id');
        $this->addForeignKey('fk-learning_process-lesson_id', '{{%learning_process}}', 'lesson_id', 'lesson', 'id');
        //---------------------Конец таблицы learning_process


        //Добавляем столбец в user
        $this->addColumn('{{%user}}', 'last_action', $this->integer()->null());
        $this->addForeignKey('fk-user-last_action', '{{%user}}', 'last_action', '{{%learning_process}}', 'id');

        //$this->addForeignKey('fk-user_history-user_id', '{{%user_history}}', 'user_id', 'user', 'id');

        //$this->addForeignKey('fk-user-version_id', '{{%user}}', 'version_id', 'user_history', 'id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {   

        $this->dropForeignKey('fk-user-last_action','{{%user}}');
        $this->dropColumn('{{%user}}', 'last_action');

        $this->dropForeignKey('fk-learning_process-user_id','{{%learning_process}}');
        $this->dropForeignKey('fk-learning_process-block_id','{{%learning_process}}');
        $this->dropForeignKey('fk-learning_process-lesson_id','{{%learning_process}}');
        $this->dropTable('{{%learning_process}}');

        $this->dropForeignKey('fk-element-block','{{%element}}');
        $this->dropTable('{{%element}}');


        $this->dropForeignKey('fk-block-lesson','{{%block}}');
        $this->dropTable('{{%block}}');

        $this->dropForeignKey('fk-lesson-level','{{%lesson}}');
        $this->dropTable('{{%lesson}}');

        $this->dropTable('{{%level}}');
    }

    
}
