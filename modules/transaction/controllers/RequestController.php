<?php
namespace app\modules\transaction\controllers;

use Yii;
use app\models\WithdrawTransactions;
use yii\web\Controller;
use app\modules\api\Api;
use app\modules\transaction\Transaction;

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
        $transaction = new Transaction($this);
        $transaction->insertTransaction($data);

        //~~ reload history page
        return $this->redirect(array('/transaction/history'));
      }

      //~~ load index page
      return $this->render('index', [
        'model' => $model,
      ]);
    }

}
