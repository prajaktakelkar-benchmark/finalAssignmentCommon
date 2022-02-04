<?php

use yii\db\Migration;

/**
 * Class m220204_174058_add_address_table
 */
class m220204_174058_add_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('tbl_address', [
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
        $this->dropTable('tbl_address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220204_174058_add_address_table cannot be reverted.\n";

        return false;
    }
    */
}
