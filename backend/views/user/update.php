<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Test */

$this->title = 'Update Account: ' . $model->u_name;

?>
<div class="test-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
