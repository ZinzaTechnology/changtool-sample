<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */

$this->title = $tile;
$this->params['breadcrumbs'][] = ['label' => 'Detail Test', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$question_count = 1;
?>
<div class="ibox">
    <div class="ibox-title">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="ibox-content">
        <div class="form-group">
            <?php foreach ($data as $question) { ?>
                <label class="control-label"><?= "Question {$question_count}" ?></label>
                <?= Html::textarea('question', $question['qc_content'], ['class' => 'form-control', 'readonly' => true]) ?>
                <ul class="panel">
                    <?php
                    foreach ($question['answer'] as $answer) {
                        $count = 0;
                        $classExtend = 'panel-heading ';
                        if (!empty($userAnswer)) {
                            if ($userAnswer["question-{$question['qc_id']}"][$count] == $answer['ac_status']) {
                                if ($answer['ac_status'] == 1) {
                                    $classExtend.= 'panel-primary';
                                } else $classExtend.= 'panel-danger';
                            } else $classExtend.= 'panel-default';
                        }else $classExtend.= 'panel-default';
                    ?>
                    <li class="<?= $classExtend ?>" style="list-style-type: upper-alpha">
                        <?= $answer['ac_content'] ?>
                    </li>
                    <?php $count++; } ?>
                </ul>
                <div class="panel panel-primary m-t-md">
                    <div class="panel-heading">True answer</div>
                    <?= Html::ul($trueAnswer[$question_count - 1], ['class' => 'panel-body list-unstyled']) ?>
                </div>
            <?php $question_count++; } ?>
        </div>
    </div>
</div>
