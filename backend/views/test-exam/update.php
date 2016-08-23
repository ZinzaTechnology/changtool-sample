<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */

$this->title = 'Edit Test Exam: ' . $testExam->te_code;
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
                'all_questions' => $all_questions,
                'paging_html' => $paging_html,
                'start' => $start,
                'test_category' => $test_category,
                'test_level' => $test_level,
            ]) ?>
        </div>

    </div>
</div>
