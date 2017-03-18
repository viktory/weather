<?php

use yii\db\Migration;

class m170318_210114_user extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger()->unsigned()->notNull(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->defaultValue(null),
            'city' => $this->string(),
            'lat' => $this->decimal(9, 6)->defaultValue(null),
            'lng' => $this->decimal(9, 6)->defaultValue(null),
            'created' => $this->bigInteger()->unsigned()->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('users');
    }
}
