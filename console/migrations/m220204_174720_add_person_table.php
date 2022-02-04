<?php

use yii\db\Migration;

/**
 * Class m220204_174720_add_person_table
 */
class m220204_174720_add_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('tbl_person', [
            'person_id' => $this->primaryKey(),
            'person_fname' => $this->string()->notNull(),
            'person_lname' => $this->string()->notNull(),
            'person_email' => $this->string()->notNull(),
            'person_phone' => $this->integer(20)->notNull(),
            'updated_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'address_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP')

        ]);

        $this->addForeignKey(
            'fk-tbl_person-address_id',
            'tbl_person',
            'address_id',
            'tbl_address',
            'address_id',
            'CASCADE'
        );
    }
    public function down()
    {
        $this->dropForeignKey(
            'fk-tbl_person-address_id',
            'tbl_person'
        );
        $this->dropTable('tbl_person');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220204_174720_add_person_table cannot be reverted.\n";

        return false;
    }
    */
}
