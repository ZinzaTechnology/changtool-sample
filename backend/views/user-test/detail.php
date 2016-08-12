<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\lib\components\AppConstant;

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
                <?php
                echo Html::textarea('question', $question['qc_content'], ['class' => 'form-control', 'readonly' => true]);
                foreach ($question['answer'] as $answer) {
                    $count = 0;
                    $questionID = "question-{$question['qc_id']}";
//                if (isset($userAnswer[$questionID])) {
//                    //User's choice
//                    if ($userAnswer[$questionID][$count] == $answer['ac_id']) {
//                        echo Html::textInput('answer', $answer['ac_content']);
//                    } else {
//                    }
//                    if ($count < count($userAnswer[$questionID]))
//                        $count++;
//                } else {
//                }
                    echo Html::textInput('answer', $answer['ac_content'], ['class' => 'form-control', 'readonly' => true]);
                }
                $question_count++;
}
            ?>
        </div>
    </div>
</div>
