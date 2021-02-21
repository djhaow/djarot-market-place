<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use app\modules\api\Api;
use app\modules\transaction\Transaction;

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

    public function actionGetApiStatus()
    {
        //~~ getting post data from client/frontend
        $request = Yii::$app->request;
        $post_data = [
            'transaction_id' => $request->post('transaction_id'),
            'withdraw_id' => $request->post('withdraw_id')
        ];

        //~~ sending data into api
        $ws = new API($this);
        list($http_status, $api_response) = $ws->getMethod($post_data['transaction_id']);

        //~~ update local database from new response data api
        $data = [
            'post' => $post_data,
            'http_status' => $http_status,
            'api_response' => $api_response
        ];
        $transaction = new Transaction($this);
        $transaction->updateTransaction($data);

        //~~ reload the page
        return $this->redirect(array('/transaction/history'));
    }

    public function actionSendApiRequest()
    {
        //~~ getting post data from client/frontend
        $request = Yii::$app->request;
        $post_data = [
            'account_number' => $request->post('bank_account_number'),
            'bank_code' => $request->post('bank_code'),
            'amount' => $request->post('amount'),
            'remark' => $request->post('remark'),
            'withdraw_id' => $request->post('withdraw_id')
        ];
        
        //~~ sending data into api
        $ws = new API($this);
        list($http_status, $api_response) = $ws->postMethod($post_data);

        //~~ update local database from new response data api
        $data = [
            'post' => $post_data,
            'http_status' => $http_status,
            'api_response' => $api_response
        ];
        $transaction = new Transaction($this);
        $transaction->updateTransaction($data);

        //~~ reload the page
        return $this->redirect(array('/transaction/history'));
    }

}
