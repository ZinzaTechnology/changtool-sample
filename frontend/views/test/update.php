<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TestExam */

$this->title = 'Update Test Exam: ' . $model->te_id;
$this->params['breadcrumbs'][] = ['label' => 'Test Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->te_id, 'url' => ['view', 'id' => $model->te_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="test-exam-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
