<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240306_200510_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string(20)->notNull(),
            'email' => $this->string(50)->notNull()->unique(),
            'password' => $this->text()->notNull(),
        ]);

        $this->createIndex(
            'idx-user-id',
            '{{%user}}',
            'id'
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
