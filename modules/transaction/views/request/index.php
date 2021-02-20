<?php
  use yii\helpers\Html;

  /* @var $this yii\web\View */
  /* @var $model app\models\WithdrawTransaction */

  $this->title = 'New Request';
  $this->params['breadcrumbs'][] = ['label' => 'Withdraw ', 'url' => ['index']];
  $this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>