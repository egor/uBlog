<?php

use yii\db\Migration;

/**
 * Class m230409_144904_add_field_to_user
 */
class m230409_144904_add_field_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('user', 'role', $this->string(25));
    }
    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('user', 'role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230409_144904_add_field_to_user cannot be reverted.\n";

        return false;
    }
    */
}
