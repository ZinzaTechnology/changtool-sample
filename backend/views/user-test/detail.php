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
            <?php foreach ($data as $question): ?>
                <label class="control-label"><?= "Question {$question_count}" ?></label>
                <div class="alert alert-info">
                    <strong><?= $question['qc_content'] ?></strong>
                </div>
                <ul class="panel">
                    <?php
                    foreach ($question['answer'] as $answer):
                        $count = 0;
                        $classExtend = '';
                        if (!empty($userAnswer)) {
                            if ($userAnswer["question-{$question['qc_id']}"][$count] == $answer['ac_status']) {
                                if ($answer['ac_status'] == 1) {
                                    $classExtend.= 'alert-success';
                                } else $classExtend.= 'alert-danger';
                            }
                        }
                        ?>
                        <li class="p-w-sm <?= $classExtend ?>" style="list-style-type: upper-alpha">
                            <?= $answer['ac_content'] ?>
                        </li>
                        <?php $count++;
                    endforeach;
                    ?>
                </ul>
                <div class="p-w-sm alert-success">
                    <?= Html::ul($trueAnswer[$question_count - 1], ['class' => 'panel-body list-unstyled']) ?>
                </div>
                <?php
                $question_count++;
            endforeach;
            ?>
        </div>
    </div>
</div>
