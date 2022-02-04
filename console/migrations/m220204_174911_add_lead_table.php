<?php

use yii\db\Migration;

/**
 * Class m220204_174911_add_lead_table
 */
class m220204_174911_add_lead_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('tbl_lead', [
            'lead_id' => $this->primaryKey(),
            'notes' => $this->string()->notNull(),
            'updated_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'person_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP')

        ]);

        $this->addForeignKey(
            'fk-tbl_lead-person_id',
            'tbl_lead',
            'person_id',
            'tbl_person',
            'person_id',
            'CASCADE'
        );
    }
    public function down()
    {
        $this->dropForeignKey(
            'fk-tbl_lead-person_id',
            'tbl_lead'
        );
        $this->dropTable('tbl_lead');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220204_174911_add_lead_table cannot be reverted.\n";

        return false;
    }
    */
}
