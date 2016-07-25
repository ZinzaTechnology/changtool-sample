<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */

$this->title = 'Create Test Exam';
$this->params['breadcrumbs'][] = ['label' => 'Test Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
