<?php

namespace app\modules\api;

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
        //~~ set url here, cz every method can be different
        $curl = "https://nextar.flip.id/disburse/$transaction_id";
        list($http_status, $response) = $this->requestCurl('GET', $curl);

        return array($http_status, $response);
    }

    public function postMethod($post)
    {
        //~~ set url here, cz every method can be different
        $curl = "https://nextar.flip.id/disburse";
        list($http_status, $response) = $this->requestCurl('POST', $curl, $post);

        return array($http_status, $response);
    }

    public function requestCurl($method, $curlHandler, $post = null)
    {
        $secretKey = "HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curlHandler);
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $secretKey);
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return array($http_status, $response);
    }

}
