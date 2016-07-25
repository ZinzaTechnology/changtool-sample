<?php
use yii\helpers\Html;

$this->title = 'Update User Test: ' . $model->ut_id;
$this->params['breadcrumbs'][] = ['label' => 'User Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ut_id, 'url' => ['view', 'id' => $model->ut_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-test-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
