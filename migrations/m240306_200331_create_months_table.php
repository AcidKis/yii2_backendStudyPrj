<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%months}}`.
 */
class m240306_200331_create_months_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%months}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(10)->notNull()->unique(),
            'created_at' => $this->datetime()->append('DEFAULT CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->datetime()->append('DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
        ]);

        $this->createIndex(
            'idx-months-id',
            '{{%months}}',
            'id'
        );

        $this->batchInsert('{{%months}}',['name'], [
            ['Январь'],
            ['Февраль'],
            ['Март'],
            ['Апрель'],
            ['Май'],
            ['Июнь'],
            ['Июль'],
            ['Август'],
            ['Сентябрь'],
            ['Октябрь'],
            ['Ноябрь'],
            ['Декабрь']
            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%months}}');
    }
}
