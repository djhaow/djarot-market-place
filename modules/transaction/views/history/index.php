<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Withdraw History';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
          [
            'attribute' => 'transaction_id',
            'label' => 'ID'
          ],
          'bank_code',
          [
            'attribute' => 'bank_account_number',
            'label' => 'Acc. No'
          ],
          [
            'attribute' => 'amount',
            'format' => 'raw',
            'value' => function ($model) {
              return "Rp. " . number_format((float)$model->amount, 2);
            }
          ],
          'status',
          'remark',
          [
            'attribute' => 'withdraw_date',
            'format' => 'raw',
            'value' => function ($model) {
              $date = date_create($model->withdraw_date);
              return date_format($date, "d M Y H:i:s");
            }
          ],
          [
            'attribute' => 'time_served',
            'format' => 'raw',
            'value' => function ($model) {
              if ($model->time_served == null) return;
              $date = date_create($model->time_served);
              return date_format($date, "d M Y H:i:s");
            }
          ],
          [
            'attribute' => 'fee',
            'format' => 'raw',
            'value' => function ($model) {
              if ($model->fee == NULL) return;
              return "Rp. " . number_format((float)$model->fee, 2);
            }
          ],
          [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'color:#337ab7'],
            'template' => '{view}',
            'buttons' => [
              'view' => function ($url, $model) {
                $view_action = "";
                if ($model->status == "FAILED") {
                  $view_action = Html::a('<span class="glyphicon glyphicon-send"></span>', $url, ['title' => Yii::t('app', 'lead-view'),]);
                } elseif($model->status == "PENDING") {
                  $view_action = Html::a('<span class="glyphicon glyphicon-refresh"></span>', $url, ['title' => Yii::t('app', 'lead-view'),]);
                }
                return $view_action;
              }
            ],
            'urlCreator' => function ($action, $model) {
              $url = "";
              if ($model->status == "FAILED") {
                $url = "/api/disburstment/send";
              } elseif($model->status == "PENDING") {
                $url = "/api/disburstment/get";
              }
              return $url;
            }
          ],
        ],
    ]); ?>

</div>