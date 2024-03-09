<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%history}}`.
 */
class m240306_200533_create_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%history}}', [
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string(20)->notNull(),
            'month' => $this->string(12)->notNull(),
            'tonnage' => $this->integer(4)->notNull(),
            'raw_type' => $this->string(12)->notNull(),
            'price' => $this->integer(4)->notNull(),
            'priceTable' => $this->json()->notNull(),
            'created_at' => $this->datetime()->append('DEFAULT CURRENT_TIMESTAMP')->notNull(),         
        ]);

        $this->createIndex(
            'idx-history-id',
            '{{%user}}',
            'id'
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%history}}');
    }
}
