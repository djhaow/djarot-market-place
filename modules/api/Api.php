<?php

namespace app\modules\api;

use Yii;
/**
 * api module definition class
 */
class Api extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function getMethod($transaction_id)
    {
        //~~ set endpoint here
        $end_point = "/disburse/$transaction_id";
        list($http_status, $response) = $this->requestCurl('GET', $end_point);

        return array($http_status, $response);
    }

    public function postMethod($post)
    {
        //~~ set endpoint here
        $end_point = "/disburse";
        list($http_status, $response) = $this->requestCurl('POST', $end_point, $post);

        return array($http_status, $response);
    }

    public function requestCurl($method, $end_point, $post = null)
    {
        $curlHandler = Yii::$app->params['api_hostname'].$end_point;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curlHandler);
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, Yii::$app->params['api_secret_key']);
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        //~~ save api log
        Yii::info([$method, $curlHandler, $http_status, $response], 'api_log');
        
        return array($http_status, $response);
    }

}
