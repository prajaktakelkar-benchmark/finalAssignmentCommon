<?php

use yii\db\Migration;

/**
 * Class m220206_085210_add_person_table
 */
class m220206_085210_add_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('person', [
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
            'fk-person-address_id',
            'person',
            'address_id',
            'addresses',
            'address_id',
            'CASCADE'
        );
    }
    public function down()
    {
        $this->dropForeignKey(
            'fk-person-address_id',
            'person'
        );
        $this->dropTable('person');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220206_085210_add_person_table cannot be reverted.\n";

        return false;
    }
    */
}
