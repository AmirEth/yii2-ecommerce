<?php

use yii\db\Migration;

/**
 * Class m240112_134218_rename_category_name_column
 */
class m240112_134218_rename_category_name_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('category', 'name', 'category_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('category', 'category_name', 'name');
    }
}
