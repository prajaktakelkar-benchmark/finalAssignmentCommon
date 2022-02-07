<?php

use yii\db\Migration;

/**
 * Class m220206_085103_add_address_table
 */
class m220206_085103_add_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('address', [
            'address_id' => $this->primaryKey(),
            'add_line1' => $this->string()->notNull(),
            'add_line2' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
            'zipcode' => $this->integer(20)->notNull(),
            'country' => $this->string()->notNull(),

        ]);
    }
    public function down()
    {
        $this->dropTable('address');
    }



    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220206_085103_add_address_table cannot be reverted.\n";

        return false;
    }
    */
}
