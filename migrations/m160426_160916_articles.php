<?php

use yii\db\Migration;
use yii\db\pgsql\Schema;

class m160426_160916_articles extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%articles}}', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string(255)->notNull(),
            'alias'       => $this->string(255)->notNull(),
            'annotation'  => $this->text(),
            'description' => $this->text()->notNull(),
            'created_at'  => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at'  => $this->timestamp(),
        ]);

        $this->createIndex('ux_articles_alias', '{{%articles}}', ['alias'], true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%articles}}');
    }
}
