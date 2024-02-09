<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%orders}}`.
 */
class m240131_132442_mYYYYMMDD_HHMMSS_add_otp_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add OTP-related fields
        $this->addColumn('{{%orders}}', 'otp', $this->string(6)->null());
        $this->addColumn('{{%orders}}', 'otp_generated_at', $this->integer()->null());
        $this->addColumn('{{%orders}}', 'otp_expiry', $this->integer()->null());

        // Add index on the OTP field for faster lookups
        $this->createIndex('idx-orders-otp', '{{%orders}}', 'otp');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop the added columns
        $this->dropColumn('{{%orders}}', 'otp');
        $this->dropColumn('{{%orders}}', 'otp_generated_at');
        $this->dropColumn('{{%orders}}', 'otp_expiry');

        // Drop the added index
        $this->dropIndex('idx-orders-otp', '{{%orders}}');
    }
}
