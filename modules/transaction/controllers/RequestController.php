<?php
namespace app\modules\transaction\controllers;

use Yii;
use app\models\WithdrawTransactions;
use yii\web\Controller;

class RequestController extends Controller
{

  /**
     * Creates a new WithdrawTransactions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionIndex()
    {
      $model = new WithdrawTransactions();

      if ($model->load(Yii::$app->request->post())) {
        $post = [
          'bank_code' => $model->bank_code,
          'account_number' => $model->bank_account_number,
          'amount' => $model->amount,
          'remark' => $model->remark
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
        $http_status = 200;
        // $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // $result_json = json_decode($result, true);
        // curl_close($ch);

        $result_json['id'] = "3372233945";
        $result_json['status'] = "PENDING";
        $result_json['timestamp'] = "2021-02-19 21:15:59";
        $result_json['beneficiary_name'] = "PT FLIP";
        $result_json['fee'] = 4000;
        $user_id = Yii::$app->user->identity->id;
        $model->seller_id = $user_id;
        if ($http_status == 200) {
          $model->api_transaction_id = (string)$result_json['id'];
          $model->status = $result_json['status'];
          $model->timestamp = $result_json['timestamp'];
          $model->beneficiary_name = $result_json['beneficiary_name'];
          $model->fee = $result_json['fee'];
        } else {
          $model->status = "FAILED";
        }
        $model->save();

        return $this->redirect(array('/transaction/history'));
      }

      return $this->render('index', [
        'model' => $model,
      ]);
    }

}