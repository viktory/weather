<?php

use yii\db\Migration;

class m170417_130238_last_command extends Migration
{
    public function safeUp()
    {
        $this->addColumn('users', 'command', $this->string()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('users', 'command');
    }
}
