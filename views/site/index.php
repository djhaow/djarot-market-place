<?php

/* @var $this yii\web\View */

$this->title = 'History Transaction';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome!</h1>
        <p class="lead">Start sell your goods.</p>
        <?php
            echo (Yii::$app->user->isGuest) ? 
                "<p><a class='btn btn-lg btn-success' href='/site/login'>Start Selling</a></p>" 
            : 
                "<p><a class='btn btn-lg btn-success' href='/transaction/history'>Check Transaction</a></p>";
        ?>
    </div>

    <div class="body-content">

    </div>
</div>