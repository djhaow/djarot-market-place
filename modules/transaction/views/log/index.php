<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Withdraw Log';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          'bank_code',
          'bank_account_number',
          [
            'attribute' => 'amount',
            'format' => 'raw',
            'value' => function ($model) {
              return "Rp. " . number_format((float)$model->amount, 2);
            }
          ],
          'beneficiary_name',
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
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'color:#337ab7'],
            'template' => '{view}',
            'buttons' => [
              'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => Yii::t('app', 'lead-view'),]);
              }
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
              if ($action === 'view') {
                $url = "/transaction/api_service";
                return $url;
              }
            }
          ],
        ],
    ]); ?>


</div>
