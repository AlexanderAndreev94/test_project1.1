<?php

use yii\db\Migration;

class m170711_055248_crate_comment_table extends Migration
{
    public function up()
    {
       $this->createTable('comment', [
          'id' => \yii\db\Schema::TYPE_INTEGER . 'NOT NULL AUTO_INCREMENT',
           'post_id' => $this->integer(),
           'content' => $this->text(),
           'user_id' => $this->integer(),
           'date_created' => $this->date(),
           'status' => $this->string(8)
       ]);
       $this->addPrimaryKey('com_id', 'comment', 'id');
       $this->addForeignKey('p_id2', 'comment', 'post_id', 'post', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('u_id2', 'user', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170711_055248_crate_comment_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170711_055248_crate_comment_table cannot be reverted.\n";

        return false;
    }
    */
}
