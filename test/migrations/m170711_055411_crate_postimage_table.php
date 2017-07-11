<?php

use yii\db\Migration;

class m170711_055411_crate_postimage_table extends Migration
{
    public function up()
    {
        $this->createTable('postimage', [
            'id' => \yii\db\Schema::TYPE_INTEGER . 'NOT NULL AUTO_INCREMENT',
            'image'=> $this->text(),
            'post_id' => $this->integer()
        ]);
        $this->addPrimaryKey('img_id', 'postimage', 'id');
        $this->addForeignKey('p_id1','postimage', 'post_id','post','id','CASCADE', 'CASCADE');
    }
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170711_055411_crate_postimage_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170711_055411_crate_postimage_table cannot be reverted.\n";

        return false;
    }
    */
}
