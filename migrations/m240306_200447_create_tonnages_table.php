<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tonnages}}`.
 */
class m240306_200447_create_tonnages_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%tonnages}}', [
            'id' => $this->primaryKey()->unsigned(),
            'value' => $this->tinyInteger(3)->notNull()->unique()->unsigned(),
            'created_at' => $this->datetime()->append('DEFAULT CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->datetime()->append('DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
        ]);

        $this->createIndex(
            'idx-tonnages-id',
            '{{%tonnages}}',
            'id'
        );

        $this->batchInsert('{{%tonnages}}',['value'], [
            [25],
            [50],
            [75],
            [100],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tonnages}}');
    }
}
