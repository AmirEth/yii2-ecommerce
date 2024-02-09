<?php

use yii\db\Migration;

/**
 * Class m240202_081122_add_phone_number_to_orders
 */
class m240202_081122_add_phone_number_to_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'phone_number', $this->string(20)->after('email'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'phone_number');
    }
}
