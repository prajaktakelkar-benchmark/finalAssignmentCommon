<?php

use yii\db\Migration;

/**
 * Class m220206_085640_add_opportunity_table
 */
class m220206_085640_add_opportunity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('opportunity', [
            'op_id' => $this->primaryKey(),
            'notes' => $this->string()->notNull(),
            'person_id' => $this->integer()->notNull(),
            'lead_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
            'fk-opportunity-person_id',
            'opportunity',
            'person_id',
            'person',
            'person_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-opportunity-lead_id',
            'opportunity',
            'lead_id',
            'lead',
            'lead_id',
            'CASCADE'
        );
    }
    public function down()
    {
        $this->dropForeignKey(
            'fk-opportunity-person_id',
            'opportunity'
        );
        $this->dropForeignKey(
            'fk-opportunity-lead_id',
            'opportunity'
        );
        $this->dropTable('opportunity');
    }



    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220206_085640_add_opportunity_table cannot be reverted.\n";

        return false;
    }
    */
}
