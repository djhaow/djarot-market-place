<?php

namespace app\modules\transaction\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\WithdrawTransactions;

use yii\web\Controller;

/**
 * Default controller for the `transaction` module
 */
class LogController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
      //~~ Get id from user login
      $user_id = Yii::$app->user->identity->id;

      $query = WithdrawTransactions::find()
        ->where(['seller_id' => $user_id]);
      $dataProvider = new ActiveDataProvider([
        'query' => $query,
      ]);
      return $this->render('index', [
        'dataProvider' => $dataProvider,
      ]);
    }
}
