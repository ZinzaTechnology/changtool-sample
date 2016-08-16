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
            <?php if (count($data)): ?>
                <?php foreach ($data as $question): ?>
                    <label class="control-label"><?= "Question {$question_count}" ?></label>
                    <div class="alert alert-info">
                        <strong><?= $question['qc_content'] ?></strong>
                    </div>
                    <div class="m-b-md">
                        <?php foreach ($question['answer'] as $answer): ?>
                            <div class="i-checks">
                                <input type="radio" disabled 
                                    <?php if (isset($userAnswer["question-{$answer['qc_id']}"]) && in_array($answer['ac_id'], $userAnswer["question-{$answer['qc_id']}"])): ?>
                                        <?= "checked" ?>
                                    <?php endif; ?>
                                >
                                <?= $answer['ac_content'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="p-w-sm alert-success">
                        <?= Html::ul($question['trueAnswer'], ['class' => 'panel-body list-unstyled']) ?>
                    </div>
                    <?php $question_count++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?= "<strong>No question found</strong>" ?>
            <?php endif; ?>
        </div>
    </div>
</div>
