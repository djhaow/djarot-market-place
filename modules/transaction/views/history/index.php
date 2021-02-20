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
            'label' => 'Trns. ID',
            'format' => 'raw',
            'value' => function ($model) {
              return '<span class="badge badge-pill badge-primary">' . $model->transaction_id . '</span>';
            }
          ],
          [
            'attribute' => 'bank_code',
            'label' => 'Bank Acc.',
            'format' => 'raw',
            'value' => function ($model) {
              return $model->bank_code . '<br><span class="badge badge-pill badge-primary">' . $model->bank_account_number . '</span>';
            }
          ],
          [
            'attribute' => 'amount',
            'format' => 'raw',
            'value' => function ($model) {
              return "Rp. " . number_format((float)$model->amount, 2);
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
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function ($model) {
              $view = "";
              if ($model->status == "FAILED"){
                $view = Html::a('<span class="glyphicon glyphicon-remove text-danger"></span>');
              } elseif($model->status == "PENDING") {
                $view = Html::a('<span class="glyphicon glyphicon-hourglass"></span>');
              } else {
                $view = Html::a('<span class="glyphicon glyphicon-ok text-success"></span>');
              }
              return $view;
            }
          ],
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
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'color:#337ab7'],
            'template' => '{view}',
            'buttons' => [
              'view' => function ($url, $model) {
                $view_action = "";
                if ($model->status == "FAILED") {
                  $view_action = Html::a('<span class="glyphicon glyphicon-send"></span>', $url, ['title' => Yii::t('app', 'resend'),]);
                } elseif($model->status == "PENDING") {
                  $view_action = Html::a('<span class="glyphicon glyphicon-refresh"></span>', $url, ['title' => Yii::t('app', 'check'),]);
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