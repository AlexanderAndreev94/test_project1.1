<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categoryTree`.
 */
class m170708_160928_create_categoryTree_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('categorytree', [
            'id' => \yii\db\Schema::TYPE_INTEGER . 'NOT NULL AUTO_INCREMENT',
            'name' => $this->string()->notNull(),
            'status' => $this->string()->notNull(),
            'tree'=> $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'position' => $this->integer()->notNull()->defaultValue(0),
        ]);
        $this->addPrimaryKey('cat_id', 'categorytree', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('categoryTree');
    }
}
