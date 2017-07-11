<?php

use yii\db\Migration;

class m170711_055341_crate_user_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => \yii\db\Schema::TYPE_INTEGER . 'NOT NULL AUTO_INCREMENT',
            'username' => $this->string(50),
            'email' => $this->string(50),
            'status' => $this->integer(),
            'role' => $this->string(10),
            'password' => $this->string(20),
            'password_salt' => $this->string(20),
            'datetime_registration' => $this->dateTime()
        ]);
        $this->addPrimaryKey('user_id', 'user', 'id');
    }

    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170711_055341_crate_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170711_055341_crate_user_table cannot be reverted.\n";

        return false;
    }
    */
}
