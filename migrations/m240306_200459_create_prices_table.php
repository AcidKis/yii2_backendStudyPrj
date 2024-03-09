<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prices}}`.
 */
class m240306_200459_create_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prices}}', [
            'id' => $this->primaryKey()->unsigned(),
            'tonnage_id' => $this->integer(11)->notNull()->unsigned(),
            'month_id' => $this->integer(11)->notNull()->unsigned(),
            'raw_type_id' => $this->integer(11)->notNull()->unsigned(),
            'price' => $this->tinyInteger(3)->notNull()->unsigned(),
        ]);
        $this->createIndex(
            'idx-price-tonnage_id',
            '{{%prices}}',
            'tonnage_id'
        );

        $this->addForeignKey(
            'fk-prices-tonnage_id',
            '{{%prices}}',
            'tonnage_id',
            '{{%tonnages}}',
            'id',
            'CASCADE',
            'NO ACTION'
        );


        $this->createIndex(
            'idx-price-month_id',
            '{{%prices}}',
            'month_id'
        );

        $this->addForeignKey(
            'fk-prices-month_id',
            '{{%prices}}',
            'month_id',
            '{{%months}}',
            'id',
            'CASCADE',
            'NO ACTION'
        );


        $this->createIndex(
            'idx-price-raw_type_id',
            '{{%prices}}',
            'raw_type_id'
        );

        $this->addForeignKey(
            'fk-prices-raw_type_id',
            '{{%prices}}',
            'raw_type_id',
            '{{%raw_types}}',
            'id',
            'CASCADE',
            'NO ACTION'
        );
        $this->execute("
          INSERT INTO `prices`(`tonnage_id`,`month_id`,`raw_type_id`,`price`)
	SELECT
		t.id AS tonnage_id,
		m.id AS month_id,
		r.id AS raw_type_id,
		FLOOR(100+RAND()*100)
	FROM `tonnages` AS t
	JOIN `months` AS m
	JOIN `raw_types` AS r;
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-prices-raw_type_id',
            '{{%prices}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-price-raw_type_id',
            '{{%prices}}'
        );


        $this->dropForeignKey(
            'fk-prices-month_id',
            '{{%prices}}'
        );


        $this->dropIndex(
            'idx-price-month_id',
            '{{%prices}}'
        );

        $this->dropForeignKey(
            'fk-prices-tonnage_id',
            '{{%prices}}'
        );


        $this->dropIndex(
            'idx-price-tonnage_id',
            '{{%prices}}'
        );

        $this->dropTable('{{%prices}}');
    }
}
