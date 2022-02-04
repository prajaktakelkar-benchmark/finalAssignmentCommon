<?php

use yii\db\Migration;

/**
 * Class m220204_175311_add_opportunity_table
 */
class m220204_175311_add_opportunity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('tbl_opportunity', [
            'op_id' => $this->primaryKey(),
            'notes' => $this->string()->notNull(),
            'person_id' => $this->integer()->notNull(),
            'lead_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
            'fk-tbl_opportunity-person_id',
            'tbl_opportunity',
            'person_id',
            'tbl_person',
            'person_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tbl_opportunity-lead_id',
            'tbl_opportunity',
            'lead_id',
            'tbl_lead',
            'lead_id',
            'CASCADE'
        );
    }
    public function down()
    {
        $this->dropForeignKey(
            'fk-tbl_opportunity-person_id',
            'tbl_opportunity'
        );
        $this->dropForeignKey(
            'fk-tbl_opportunity-lead_id',
            'tbl_opportunity'
        );
        $this->dropTable('tbl_opportunity');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220204_175311_add_opportunity_table cannot be reverted.\n";

        return false;
    }
    */
}
