<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sellers_account}}`.
 */
class m210220_022532_create_sellers_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sellers_account}}', [
            'seller_id' => $this->primaryKey(32),
            'name' => $this->string(64)->notNull(),
            'bank_code' => $this->string(12)->notNull(),
            'bank_account_number' => $this->string(12)->notNull(),
            'account_balance' => $this->decimal(15, 2),
            'join_date' => $this->dateTime()
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->batchInsert('{{%sellers_account}}', ['seller_id', 'name', 'bank_code', 'bank_account_number', 'account_balance', 'join_date'], [
            ['1', 'Toko Makmur', 'bni', '433418191215', '8000000', '2020-04-21 12:52:12'],
            ['2', 'Toko Jaya', 'mandiri', '145995464535', '750000', '2021-04-21 15:12:20'],
            ['3', 'Toko Sukses', 'bca', '919106613669', '14000000', '2020-01-19 17:10:19']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sellers_account}}');
    }
}
