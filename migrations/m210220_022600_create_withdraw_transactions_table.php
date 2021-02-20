<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%withdraw_transactions}}`.
 */
class m210220_022600_create_withdraw_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%withdraw_transactions}}', [
            'withdraw_id' => $this->primaryKey(32),
            'seller_id' => $this->integer(32)->notNull(),
            'bank_code' => $this->string(12)->notNull(),
            'bank_account_number' => $this->string(12)->notNull(),
            'account_balance' => $this->decimal(15, 2)->notNull(),
            'amount' => $this->decimal(15, 2)->notNull(),
            'fee' => $this->decimal(15, 2),
            'beneficiary_name' => $this->string(64),
            'status' => $this->string(12)->notNull(),
            'remark' => $this->string(128),
            'receipt' => $this->string(256),
            'timestamp' => $this->dateTime(),
            'time_served' => $this->dateTime(),
            'transaction_id' => $this->string(12),
            'withdraw_date' => $this->dateTime(),
            'api_response_status_code' => $this->string(3),
            'api_response_status_message' => $this->text()
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // creates index for column `author_id`
        $this->createIndex('idx-withdraw_transaction-seller_id', '{{%withdraw_transactions}}', 'seller_id');
        $this->createIndex('idx-withdraw_transaction-transaction_id', '{{%withdraw_transactions}}', 'transaction_id');

        $field_comment = [
            'account_balance' => 'last seller account balance',
            'amount' => 'seller withdrawal amount',
            'transaction_id' => 'transaction_id data from response API',
            'beneficiary_name' => 'beneficiary_name data from response API',
            'fee' => 'fee data from response API',
            'remark' => 'remark data from response API',
            'receipt' => 'receipt data from response API',
            'status' => 'status data from response API (PENDING, SUCCESS), If response failed (FAILED)',
            'time_served' => 'time_served data from response API',
            'timestamp' => 'time_stamp data from response API',
            'withdraw_date' => 'request withdraw date from seller',
            'api_response_status_code' => 'http response status code from API',
            'api_response_status_message' => 'http response status message from API'
        ];
        foreach ($field_comment as $field => $comment) {
            $this->addCommentOnColumn('{{%withdraw_transactions}}', $field, $comment);
        }

        $this->batchInsert('{{%withdraw_transactions}}', ['seller_id', 'bank_code', 'bank_account_number', 'account_balance', 'amount', 'beneficiary_name', 'status', 'receipt', 'remark', 'timestamp', 'time_served', 'transaction_id', 'withdraw_date', 'fee', 'api_response_status_code', 'api_response_status_message'], [
            ['1', 'bni', '433418191215', '300000', '300000', 'PT FLIP', 'SUCCESS', 'https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg', 'First withdraw', '2020-03-04 14:30:27', '2020-03-04 14:40:27', '91239123', '2020-03-04 12:40:09', '4000', '200', '{"id":324383,"amount":10000,"status":"SUCCESS","timestamp":"2021-02-20 21:10:41","bank_code":"bni","account_number":"1234567890","beneficiary_name":"PT FLIP","remark":"sample remark","receipt":"https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg","time_served":"2021-02-20 21:19:41","fee":4000}'],
            ['1', 'bni', '433418191215', '780000', '780000', 'PT FLIP', 'SUCCESS', 'https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg', 'Need Quick', '2020-08-05 07:54:51', '2020-08-05 08:04:51', '324383', '2020-08-04 22:40:11', '4000', '200', '{"id":324383,"amount":10000,"status":"SUCCESS","timestamp":"2021-02-20 21:10:41","bank_code":"bni","account_number":"1234567890","beneficiary_name":"PT FLIP","remark":"sample remark","receipt":"https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg","time_served":"2021-02-20 21:19:41","fee":4000}'],
            ['1', 'bni', '433418191215', '4500000', '4500000', 'PT FLIP', 'PENDING', 'https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg', 'I want withdraw my balance', '2021-01-05 09:18:09', '2021-01-05 09:28:09', '3242311', '2021-01-04 09:28:09', '4000', '200', '{"id":3242311,"amount":10000,"status":"PENDING","timestamp":"2021-02-20 21:11:14","bank_code":"bni","account_number":"1234567890","beneficiary_name":"PT FLIP","remark":"sample remark","receipt":"https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg","time_served":"2021-02-20 21:20:14","fee":4000}'],
            ['1', 'bni', '433418191215', '500000', '4500000', NULL, 'FAILED', NULL, 'Thanks', NULL, NULL, NULL, '2021-01-04 09:28:09', NULL, NULL, NULL],
            ['2', 'mandiri', '145995464535', '8000000', '8000000', 'PT FLIP', 'SUCCESS', 'https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg', 'Thanks', '2020-03-04 14:30:16', '2020-03-04 14:40:16', '54654345', '2020-03-04 12:40:21', '4000', '200', '{"id":54654345,"amount":10000,"status":"SUCCESS","timestamp":"2021-02-20 21:11:33","bank_code":"bni","account_number":"1234567890","beneficiary_name":"PT FLIP","remark":"sample remark","receipt":"https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg","time_served":"2021-02-20 21:20:33","fee":4000}'],
            ['2', 'mandiri', '145995464535', '2800000', '2800000', 'PT FLIP', 'SUCCESS', 'https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg', 'Need Quick', '2020-09-04 18:30:18', '2020-09-04 18:40:18', '23414234', '2020-09-04 18:10:49', '4000', '200', '{"id":23414234,"amount":10000,"status":"SUCCESS","timestamp":"2021-02-20 21:11:33","bank_code":"bni","account_number":"1234567890","beneficiary_name":"PT FLIP","remark":"sample remark","receipt":"https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg","time_served":"2021-02-20 21:20:33","fee":4000}'],
            ['2', 'mandiri', '145995464535', '1400000', '1400000', NULL, 'FAILED', NULL, 'Need Quick', NULL, NULL, NULL, '2020-09-04 18:10:49', NULL, NULL, NULL],
            ['3', 'bca', '919106613669', '4500000', '4500000', 'PT FLIP', 'SUCCESS', 'https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg', 'Thanks for your service', '2020-02-05 08:30:12', '2020-02-05 08:40:12', '234234', '2021-02-04 18:10:37', '4000', '200', '{id":234234,"amount":10000,"status":"SUCCESS","timestamp":"2021-02-20 21:05:16","bank_code":"bni","account_number":"1234567890","beneficiary_name":"PT FLIP","remark":"sample remark","receipt":"https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg","time_served":"2021-02-20 21:14:16","fee":4000}'],
            ['3', 'bca', '919106613669', '8800000', '8800000', 'PT FLIP', 'PENDING', 'https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg', 'Thanks for time', '2020-02-19 08:30:09', '2020-02-19 08:40:09', '4512323', '2021-02-19 06:10:43', '4000', '200', '{"id":4512323,"amount":10000,"status":"PENDING","timestamp":"2021-02-20 21:12:01","bank_code":"bni","account_number":"1234567890","beneficiary_name":"PT FLIP","remark":"sample remark","receipt":"https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg","time_served":"2021-02-20 21:21:01","fee":4000}']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%withdraw_transactions}}');
    }
}
