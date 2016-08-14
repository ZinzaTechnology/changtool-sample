<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Test */

$this->title = 'New Account';

?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcreate', [
        'model' => $model,
    ]) ?>

</div>
