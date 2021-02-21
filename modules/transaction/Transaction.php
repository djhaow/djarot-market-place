<?php

namespace app\modules\transaction;

use Yii;
use app\models\WithdrawTransactions;

/**
 * transaction module definition class
 */
class Transaction extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\transaction\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function insertTransaction($data)
    {
      $model = $data['model'];
      $http_status = $data['http_status'];
      $api_response = $data['api_response'];
      $response = json_decode($api_response, true);

      //~~ get active seller_id/user_id
      $model->seller_id = Yii::$app->user->identity->id;
      $model->account_balance = $model->amount;
      $model->status = "FAILED";
      if ($http_status == 200) {
        $model->transaction_id = (string)$response['id'];
        $model->status = $response['status'];
        $model->timestamp = $response['timestamp'];
        $model->beneficiary_name = $response['beneficiary_name'];
        $model->fee = $response['fee'];

        //~~ set success flash message
        Yii::$app->session->setFlash('success', "Received from Flip API");
      } else {
        //~~ set warning flash message
        Yii::$app->session->setFlash('warning', "Failed connect with Flip API");
      }
      $model->api_response_status_code = (string)$http_status;
      $model->api_response_status_message = $api_response;
      $model->save();
    }
    
    public function updateTransaction($data)
    {
        $post = $data['post'];
        $http_status = $data['http_status'];
        $api_response = $data['api_response'];
        $response = json_decode($api_response, true);

        $withdraw_transaction = WithdrawTransactions::findOne($post['withdraw_id']);
        if ($http_status == 200) {
            $withdraw_transaction->beneficiary_name = $response['beneficiary_name'];
            $withdraw_transaction->fee = $response['fee'];
            $withdraw_transaction->receipt = $response['receipt'];
            $withdraw_transaction->status = $response['status'];
            $withdraw_transaction->time_served = $response['time_served'] != "0000-00-00 00:00:00" ? $response['time_served'] : NULL;
            $withdraw_transaction->transaction_id = (string)$response['id'];
            $withdraw_transaction->timestamp = $response['timestamp'];

            //~~ set success flash message
            Yii::$app->session->setFlash('success', "Received from Flip API");
        } else {
            //~~ set warningflash message
            Yii::$app->session->setFlash('warning', "Failed connect with Flip API");
        }
        $withdraw_transaction->api_response_status_code = (string)$http_status;
        $withdraw_transaction->api_response_status_message = $api_response;
        $withdraw_transaction->save();
    }

}
