<?php

namespace app\modules\api\controllers;

use yii\web\Controller;
use app\models\WithdrawTransactions;
use yii\db\ActiveRecord;

/**
 * Default controller for the `api` module
 */
class DisburstmentController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGet()
    {
        //~~ TODO : get id from front_end & check from database if it's not success status
        $transaction_id = "3";
        $api_transaction_id = "1";

        // $curlHandler = "https://nextar.flip.id/disburse/$api_transaction_id";
        // $secretKey = "HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41";
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $curlHandler);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($ch, CURLOPT_USERPWD, $secretKey);
        // $result = curl_exec($ch);
        $result = '{"id":1,"amount":10000,"status":"SUCCESS","timestamp":"2021-02-19 15:01:30","bank_code":"bni","account_number":"1234567890","beneficiary_name":"PT FLIP","remark":"sample remark","receipt":"https:\/\/flip-receipt.oss-ap-southeast-5.aliyuncs.com\/debit_receipt\/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg","time_served":"2021-02-19 15:10:30","fee":4000}';
        $result_json = json_decode($result, true);
        // curl_close($ch);

        $withdraw_transaction = WithdrawTransactions::findOne($transaction_id);
        $withdraw_transaction->status = $result_json['status'];
        $withdraw_transaction->time_served = $result_json['time_served'];
        $withdraw_transaction->receipt = $result_json['receipt'];
        $withdraw_transaction->save();

        return $this->redirect(array('/transaction/log'));
    }

    public function actionSend()
    {
        $transaction_id = "7";

        $post = [
            'bank_code' => 'mandiri',
            'account_number' => '145995464535',
            'amount' => "1400000",
            'remark' => "Need Quick",
            'transaction_id' => '7'
        ];

        // $curlHandler = "https://nextar.flip.id/disburse";
        // $secretKey = "HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41";
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $curlHandler);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($ch, CURLOPT_USERPWD, $secretKey);
        // $result = curl_exec($ch);
        // $result_json = json_decode($result, true);
        // curl_close($ch);
        
        $result_json['id'] = "3372233945";
        $result_json['status'] = "PENDING";
        $result_json['timestamp'] = "2021-02-19 21:15:59";
        $result_json['beneficiary_name'] = "PT FLIP";
        $result_json['fee'] = 4000;
        $withdraw_transaction = WithdrawTransactions::findOne($post['transaction_id']   );
        $withdraw_transaction->api_transaction_id = (string)$result_json['id'];
        $withdraw_transaction->status = $result_json['status'];
        $withdraw_transaction->timestamp = $result_json['timestamp'];
        $withdraw_transaction->beneficiary_name = $result_json['beneficiary_name'];
        $withdraw_transaction->fee = $result_json['fee'];
        $withdraw_transaction->save();

        // TODO : save response into local database
        return $this->redirect(array('/transaction/log'));
    }
}
