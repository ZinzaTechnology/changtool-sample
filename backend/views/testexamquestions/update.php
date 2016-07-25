<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */

$this->title = 'Update Test Exam Questions: ' . $model->te_id;
$this->params['breadcrumbs'][] = ['label' => 'Test Exam Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->te_id, 'url' => ['view', 'te_id' => $model->te_id, 'q_id' => $model->q_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="test-exam-questions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
