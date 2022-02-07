<?php

use yii\db\Migration;

/**
 * Class m220206_085828_add_customer_table
 */
class m220206_085828_add_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('customer', [
            'customer_id' => $this->primaryKey(),
            'notes' => $this->string()->notNull(),
            'op_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
            'fk-customer-op_id',
            'customer',
            'op_id',
            'opportunity',
            'op_id',
            'CASCADE'
        );

    
    }
    public function down()
    {
        $this->dropForeignKey(
            'fk-customer-op_id',
            'customer'
        );
        
        $this->dropTable('customer');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220206_085828_add_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
