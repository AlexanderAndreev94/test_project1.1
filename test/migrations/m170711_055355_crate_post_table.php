<?php

use yii\db\Migration;

class m170711_055355_crate_post_table extends Migration
{
    public function up()
    {
        $this->createTable('post', [
           'id' => \yii\db\Schema::TYPE_INTEGER . 'NOT NULL AUTO_INCREMENT',
            'title' => $this->string(50),
            'content' => $this->text(),
            'category_id'=> $this->integer(),
            'status' => $this->integer(),
            'pub_date' => $this->date(),
        ]);
        $this->addPrimaryKey('p_id', 'post', 'id');
        $this->addForeignKey('c_id', 'post', 'category_id', 'categorytree', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170711_055355_crate_post_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170711_055355_crate_post_table cannot be reverted.\n";

        return false;
    }
    */
}
