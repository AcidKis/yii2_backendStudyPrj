<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%raw_types}}`.
 */
class m240306_200408_create_raw_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%raw_types}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->char(10)->notNull()->unique(),
            'created_at' => $this->datetime()->append('DEFAULT CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->datetime()->append('DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
        ]);

        $this->createIndex(
            'idx-raw_types-id',
            '{{%raw_types}}',
            'id'
        );

        $this->batchInsert('{{%raw_types}}',['name'], [
            ['Шрот'],
            ['Жмых'],
            ['Соя'],

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%raw_types}}');
    }
}
