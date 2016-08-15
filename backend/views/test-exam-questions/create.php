<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */

$this->title = 'Create Test Exam Questions';
$this->params['breadcrumbs'][] = ['label' => 'Test Exam Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-questions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
