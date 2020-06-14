<?php

use yii\db\Migration;

/**
 * Class m200614_093209_fix_collumn_charset
 */
class m200614_093209_fix_collumn_charset extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('entry', 'regulator', $this->string()->append('CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('entry', 'regulator', 'string not null');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200614_093209_fix_collumn_charset cannot be reverted.\n";

        return false;
    }
    */
}
