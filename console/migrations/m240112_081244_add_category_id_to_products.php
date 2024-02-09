<?php

use yii\db\Migration;

/**
 * Class m240112_081244_add_category_id_to_products
 */
class m240112_081244_add_category_id_to_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'category_id', $this->integer());

        // Add foreign key constraint
        $this->addForeignKey(
            'fk-product-category_id',
            '{{%products}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product-category_id', '{{%products}}');
        $this->dropColumn('{{%products}}', 'category_id');
    }
}
