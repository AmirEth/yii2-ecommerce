<?php

use yii\db\Migration;

/**
 * creation of table `shops`.
 */
class m240125_061759_create_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('shops', [
            'id' => $this->primaryKey(),
            'shops_name' => $this->string()->notNull(),
            'description' => $this->text(),
            'image' => $this->string(),
            'logo' => $this->string(),
            'tags' => $this->string(),
            'opening_days' => $this->json(),
            'shops_status' => $this->boolean()->defaultValue(true),
            'average_rating' => $this->decimal(3, 2)->defaultValue(0.0),
            'category' => $this->string(),
            'social_media_links' => $this->json(), 
            'user_id' => $this->integer(), 
            'cif' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-shops-user',
            'shops',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk-shops-user', 'shops');

        $this->dropTable('shops');
    }
}
