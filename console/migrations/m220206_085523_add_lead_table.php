<?php

use yii\db\Migration;

/**
 * Class m220206_085523_add_lead_table
 */
class m220206_085523_add_lead_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('lead', [
            'lead_id' => $this->primaryKey(),
            'notes' => $this->string()->notNull(),
            'updated_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'person_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP')

        ]);

        $this->addForeignKey(
            'fk-lead-person_id',
            'lead',
            'person_id',
            'person',
            'person_id',
            'CASCADE'
        );
    }
    public function down()
    {
        $this->dropForeignKey(
            'fk-lead-person_id',
            'lead'
        );
        $this->dropTable('lead');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220206_085523_add_lead_table cannot be reverted.\n";

        return false;
    }
    */
}
