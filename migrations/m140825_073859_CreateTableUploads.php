<?php

use yii\db\Schema;
use yii\db\Migration;

class m140825_073859_CreateTableUploads extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%uploads}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'type' => Schema::TYPE_STRING . ' NULL',
            'size' => Schema::TYPE_STRING . ' NULL',
            'path' => Schema::TYPE_STRING . ' NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NULL',

            'module' => Schema::TYPE_STRING . ' NULL',
            'controller' => Schema::TYPE_STRING . ' NULL',
            'action' => Schema::TYPE_STRING . ' NULL',

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%uploads}}');
    }
}
