<?php

namespace app\modules\transaction\controllers;

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
      $query = WithdrawTransactions::find();
      $dataProvider = new ActiveDataProvider([
        'query' => $query,
      ]);
      return $this->render('index', [
          'dataProvider' => $dataProvider,
      ]);
    }
}
