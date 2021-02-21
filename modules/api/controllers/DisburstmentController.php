<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use app\models\WithdrawTransactions;
use app\modules\api\Api;

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
        $this->updateTransaction($data);

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
        $this->updateTransaction($data);

        //~~ reload the page
        return $this->redirect(array('/transaction/history'));
    }

    private function updateTransaction($data)
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
