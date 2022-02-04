<?php

use yii\db\Migration;

/**
 * Class m220204_175733_add_customer_table
 */
class m220204_175733_add_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $this->createTable('tbl_customer', [
            'customer_id' => $this->primaryKey(),
            'notes' => $this->string()->notNull(),
            'op_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->null()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
            'fk-tbl_customer-op_id',
            'tbl_customer',
            'op_id',
            'tbl_opportunity',
            'op_id',
            'CASCADE'
        );

    
    }
    public function down()
    {
        $this->dropForeignKey(
            'fk-tbl_customer-op_id',
            'tbl_customer'
        );
        
        $this->dropTable('tbl_customer');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220204_175733_add_customer_table cannot be reverted.\n";

        return false;
    }
    */
}