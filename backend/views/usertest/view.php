<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */

$this->title = $model->te_id;
$this->params['breadcrumbs'][] = ['label' => 'Test Exam Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-questions-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php foreach ($info as $element) { ?>
        <h1><?= $element['qc_content'] ?></h1>
        <?php foreach ($element['answer'] as $answer) { ?>
            <h3><?= $answer['ac_status']==1?'True':'False'?> - <?= $answer['ac_content']?></h3>
        <?php } ?>
    <?php } ?>

</div>
