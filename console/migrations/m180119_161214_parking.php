<?php

use console\migrations\Migration;

use common\models\{Stand,Station,Session,User};
use backend\models\{Properties,PropertiesValue};


class m180119_161214_parking extends Migration
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

        $this->createTable(Station::tableName(),[
            'id' => $this->primaryKey(),
            'code'=> $this->integer()->notNull()->unique(),
            'latitude'=>  $this->string(50)->notNull(),
            'longitude'=>  $this->string(50)->notNull(),
            'ip'=>  $this->string(15)->notNull()->unique(),
            'address'=> $this->string(255)->notNull(),
            'isDeleted'=> $this->smallInteger()->null()->defaultValue(0),
            'version_id'=> $this->integer()->null(),

        ], $tableOptions);

        $this->createTable(Station::resourceTableName(),[
            'id' => $this->primaryKey(),
            'entity_id' => $this->integer()->notNull(),
            'code'=> $this->integer()->notNull(),
            'latitude'=>  $this->string(50)->notNull(),
            'longitude'=>  $this->string(50)->notNull(),
            'ip'=>  $this->string(15)->notNull(),
            'address'=> $this->string(255)->notNull(),
            
            'created_at' => $this->integer()->notNull(),
            'user_id'=>$this->integer()->null(),
            'type_action'=>$this->string()->notNull()->defaultValue("created"),
            'version'=>$this->integer()->notNull()->defaultValue(1),
            'isDeleted'=>$this->smallInteger()->null()->defaultValue(0),
            
            "FOREIGN KEY ([[entity_id]]) REFERENCES ".Station::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            "FOREIGN KEY ([[user_id]]) REFERENCES ".User::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->addForeignKey('fk-station-version_id',Station::tableName(), 'version_id',Station::resourceTableName(), 'id');


        $this->createTable(Stand::tableName(),[
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull(),
            'station_id' => $this->integer()->notNull(),
            'isDeleted'=> $this->smallInteger()->null()->defaultValue(0),
            'version_id'=> $this->integer()->null(),
            "FOREIGN KEY ([[station_id]]) REFERENCES ".Station::tableName()."([[id]]) ".
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable(Stand::resourceTableName(),[
            'id' => $this->primaryKey(),
            'entity_id' => $this->integer()->notNull(),
            'number' => $this->integer()->notNull(),
            'station_id' => $this->integer()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'user_id'=>$this->integer()->null(),
            'type_action'=>$this->string()->notNull()->defaultValue("created"),
            'version'=>$this->integer()->notNull()->defaultValue(1),
            'isDeleted'=>$this->smallInteger()->null()->defaultValue(0),
            
            "FOREIGN KEY ([[entity_id]]) REFERENCES ".Stand::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            "FOREIGN KEY ([[user_id]]) REFERENCES ".User::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->addForeignKey('fk-stand-version_id',Stand::tableName(), 'version_id',Stand::resourceTableName(), 'id');


        $this->createTable(Session::tableName(),[
            'id' => $this->primaryKey(),
            'stand_id'=>$this->integer()->notNull(),
            'start_time'=>$this->timestamp()->notNull(),
            'finish_time'=>$this->timestamp(),
            'client_id'=>$this->integer()->notNull(),
            
            'accepted'=>$this->smallInteger()->null()->defaultValue(0),
            'actual'=>$this->smallInteger()->null()->defaultValue(1),

            'isDeleted'=> $this->smallInteger()->null()->defaultValue(0),
            'version_id'=> $this->integer()->null(),

            "FOREIGN KEY ([[stand_id]]) REFERENCES ".Stand::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            "FOREIGN KEY ([[client_id]]) REFERENCES ".User::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);


        $this->createTable(Session::resourceTableName(),[
            'id' => $this->primaryKey(),
            'entity_id' => $this->integer()->notNull(),
            'stand_id'=>$this->integer()->notNull(),
            'start_time'=>$this->timestamp()->notNull(),
            'finish_time'=>$this->timestamp(),
            'client_id'=>$this->integer()->notNull(),
            
            'accepted'=>$this->smallInteger()->null()->defaultValue(0),
            'actual'=>$this->smallInteger()->null()->defaultValue(1),

            'created_at' => $this->integer()->notNull(),
            'user_id'=>$this->integer()->null(),
            'type_action'=>$this->string()->notNull()->defaultValue("created"),
            'version'=>$this->integer()->notNull()->defaultValue(1),
            'isDeleted'=>$this->smallInteger()->null()->defaultValue(0),
            
            "FOREIGN KEY ([[entity_id]]) REFERENCES ".Session::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            "FOREIGN KEY ([[user_id]]) REFERENCES ".User::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);
        
        $this->addForeignKey('fk-session-version_id',Session::tableName(), 'version_id',Session::resourceTableName(), 'id');



        // Properties
        $this->createTable(Properties::tableName(),[
            "id"=>$this->primaryKey(),
            "name"=>$this->string()->notNull()->unique(),
            "title"=>$this->string()->notNull(),
            "critical_down_time"=>$this->integer()->defaultValue(0),
            "isDeleted"=>$this->smallInteger()->null()->defaultValue(0),
        ]);

        // StationPropertyValues
        $this->createTable(PropertiesValue::tableName(),[
            "id"=>$this->primaryKey(),
            "station_id"=>$this->integer()->notNull(),
            "property_id"=>$this->integer()->notNull(),
            "value"=>$this->string()->defaultValue(0),
            "isActive"=>$this->smallInteger()->null()->defaultValue(1),
            "version_id"=>$this->integer()->null(),
        ]);


        //StationPropertyValues_history
        $this->createTable(PropertiesValue::resourceTableName(),[
            'id' => $this->primaryKey(),
            'entity_id' => $this->integer()->notNull(),
            "station_id"=>$this->integer()->notNull(),
            "property_id"=>$this->integer()->notNull(),
            "value"=>$this->string()->defaultValue(0),
            "isActive"=>$this->smallInteger()->null()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'user_id'=>$this->integer()->null(),
            'type_action'=>$this->string()->notNull()->defaultValue("created"),
            'version'=>$this->integer()->notNull()->defaultValue(1),
            "FOREIGN KEY ([[entity_id]]) REFERENCES ".PropertiesValue::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            "FOREIGN KEY ([[user_id]]) REFERENCES ".User::tableName()."([[id]]) " . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);


        $this->addForeignKey('fk-property_value-version_id',PropertiesValue::tableName(), 'version_id',PropertiesValue::resourceTableName(), 'id');

        $this->createStoredFunctions();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {   

        $this->dropStoredFunctions();

        $this->dropForeignKey('fk-property_value-version_id',PropertiesValue::tableName());
        $this->dropTable(PropertiesValue::resourceTableName());
        $this->dropTable(PropertiesValue::tableName()); 

        $this->dropTable(Properties::tableName()); 
        
        $this->dropForeignKey('fk-session-version_id',Session::tableName());
        $this->dropTable(Session::resourceTableName());
        $this->dropTable(Session::tableName()); 

        

        $this->dropForeignKey('fk-stand-version_id',Stand::tableName());
        $this->dropTable(Stand::resourceTableName());
        $this->dropTable(Stand::tableName());

        $this->dropForeignKey('fk-station-version_id',Station::tableName());
        $this->dropTable(Station::resourceTableName());
        $this->dropTable(Station::tableName());
    }




    public function createStoredFunctions(){
        if ($this->isMSSQL()) {

            $session = Session::tableName();
            $stand = Stand::tableName();
            $station = Station::tableName();

            /**
            * удаление и создание функции func_getTableStatusStationById
            */


            $sql = <<<SQL
                IF OBJECT_ID('func_getTableStatusStationById') IS NOT NULL
                    DROP FUNCTION func_getTableStatusStationById
        
SQL;
        $this->execute($sql);


            $sql = <<<SQL
            
            CREATE FUNCTION func_getTableStatusStationById (@stationId int)
            RETURNS @status TABLE (common int ,free int)
            AS
            BEGIN
                
                declare @v_common int = 0;
                declare @v_free int = 0;

                --SET NOCOUNT ON;

                -- total stands on station
                SELECT @v_common = COUNT({$stand}.id) FROM [dbo].{$stand} Where {$stand}.station_id = @stationId and {$stand}.isDeleted = 0;

                -- free stands on station
                SELECT @v_free = count({$stand}.id) FROM dbo.{$stand}
                WHERE {$stand}.station_id = @stationId and {$stand}.isDeleted = 0 and not exists(
                        SELECT {$session}.id FROM dbo.{$session} WHERE {$session}.stand_id = {$stand}.id and {$session}.finish_time is NULL and {$session}.actual = 1
                        );

                insert into @status SELECT @v_common, @v_free;

                return;
            END
SQL;
            $this->execute($sql);


            /**
            * удаление и создание функции func_getFreeStandStationById
            */
            $sql = <<<SQL
                IF OBJECT_ID('func_getFreeStandStationById') IS NOT NULL
                    DROP FUNCTION func_getFreeStandStationById
        
SQL;
        $this->execute($sql);

            $sql= <<<SQL
            CREATE FUNCTION func_getFreeStandStationById (@stationID int)
            Returns int

            Begin
                declare @v_free int = 0;
                
                SELECT @v_free = s.free FROM func_getTableStatusStationById(@stationID) as s;
                
                return @v_free
            end
SQL;
            $this->execute($sql);




             /**
            * удаление и создание процедуры proc_getMapStations
            */
            $sql = <<<SQL
                IF OBJECT_ID('proc_getMapStations') IS NOT NULL
                    DROP PROCEDURE proc_getMapStations
        
SQL;
        $this->execute($sql);

            $sql= <<<SQL
            CREATE PROCEDURE proc_getMapStations
                @param int = 0
            AS
            BEGIN
                SET NOCOUNT ON;
                SELECT id,code,latitude,longitude,dbo.func_getFreeStandStationById(id) as free FROM {$station} WHERE isDeleted = 0;
            END
SQL;
            $this->execute($sql);
        }
    }















    public function dropStoredFunctions(){
        
        // Функция func_getTableStatusStationById
        $sql = <<<SQL
        IF OBJECT_ID('dbo.func_getTableStatusStationById') is not null
            DROP FUNCTION dbo.func_getTableStatusStationById
        
SQL;
        $this->execute($sql);


        //Функция func_getFreeStandStationById
        $sql = <<<SQL
        IF OBJECT_ID('dbo.func_getFreeStandStationById') is not null
            DROP FUNCTION dbo.func_getFreeStandStationById
        
SQL;
        $this->execute($sql);


        /**
        * удаление и создание процедуры proc_getMapStations
        */
        $sql = <<<SQL
            IF OBJECT_ID('proc_getMapStations') IS NOT NULL
                DROP PROCEDURE proc_getMapStations
        
SQL;
        $this->execute($sql);
    }

}
