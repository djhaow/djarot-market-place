<?php
namespace app\modules\transaction\controllers;

use Yii;
use app\models\WithdrawTransactions;
use yii\web\Controller;
use app\modules\api\Api;

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
        //~~ set data from client/frontend to sending into api
        $post_data = [
          'bank_code' => $model->bank_code,
          'account_number' => $model->bank_account_number,
          'amount' => $model->amount,
          'remark' => $model->remark
        ];

        //~~ sending data into api
        $ws = new API($this);
        list($http_status, $api_response) = $ws->postMethod($post_data);

        //~~ create new data to db
        $data = [
          'model' => $model,
          'http_status' => $http_status,
          'api_response' => $api_response
        ];
        $this->insertTransaction($data);

        //~~ reload history page
        return $this->redirect(array('/transaction/history'));
      }

      //~~ load index page
      return $this->render('index', [
        'model' => $model,
      ]);
    }

    private function insertTransaction($data)
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

}
