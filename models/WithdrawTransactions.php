<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "withdraw_transactions".
 *
 * @property int $transaction_id
 * @property int $seller_id
 * @property string $bank_code
 * @property string $bank_account_number
 * @property float $account_balance Last account balance from seller
 * @property float $amount seller withdrawal amount
 * @property string|null $beneficiary_name beneficiary_name data from response API
 * @property string $status status data from response API (PENDING,SUCCESS), If response failed (FAILED)
 * @property string|null $remark remark data from response API
 * @property string|null $receipt receipt data from response API
 * @property string|null $timestamp time_stamp data from response API
 * @property string|null $time_served time_served data from response API
 * @property string|null $api_transaction_id transaction_id data from response API
 * @property string|null $withdraw_date request withdraw date from seller
 * @property float|null $fee fee data from response API
 */
class WithdrawTransactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'withdraw_transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seller_id', 'bank_code', 'bank_account_number', 'account_balance', 'amount', 'status'], 'required'],
            [['seller_id'], 'integer'],
            [['account_balance', 'amount', 'fee'], 'number'],
            [['timestamp', 'time_served', 'withdraw_date'], 'safe'],
            [['bank_code', 'bank_account_number', 'status', 'api_transaction_id'], 'string', 'max' => 12],
            [['beneficiary_name'], 'string', 'max' => 64],
            [['remark'], 'string', 'max' => 128],
            [['receipt'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => 'Transaction ID',
            'seller_id' => 'Seller ID',
            'bank_code' => 'Bank Code',
            'bank_account_number' => 'Bank Account Number',
            'account_balance' => 'Account Balance',
            'amount' => 'Amount',
            'beneficiary_name' => 'Beneficiary Name',
            'status' => 'Status',
            'remark' => 'Remark',
            'receipt' => 'Receipt',
            'timestamp' => 'Timestamp',
            'time_served' => 'Time Served',
            'api_transaction_id' => 'Api Transaction ID',
            'withdraw_date' => 'Withdraw Date',
            'fee' => 'Fee',
        ];
    }
}
