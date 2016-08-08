<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */

$this->title = 'Edit Test Exam: ' . $testExam->te_id;
$this->params['breadcrumbs'][] = ['label' => 'Test Manager', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $testExam->te_id, 'url' => ['view', 'id' => $testExam->te_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>

<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>

    <div class="ibox-content">

        <div class="test-exam-update">
            <?= $this->render('_edit_form', [
                'testExam' => $testExam,
                'questions' => $questions,
                'testCategory' => $testCategory,
                'testLevel' => $testLevel,
            ]) ?>
        </div>

    </div>
</div>
