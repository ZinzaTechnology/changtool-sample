<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */

$this->title = $tile;
$this->params['breadcrumbs'][] = ['label' => 'User Test dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-questions-view">

    <h1><?= Html::encode($this->title) ?></h1>
<?php   foreach ($info as $element) {   ?>
        <h1><?= $element['qc_content'] ?></h1>
<?php
        foreach ($element['answer'] as $answer) {
            $count = 0;
            $questionID = "question-{$element['qc_id']}";
            if (isset($userAnswer[$questionID])) {
                if ($userAnswer[$questionID][$count] == $answer['ac_id']) {
?>
                    <h3>[User's choice] <?= $answer['ac_status'] == 1 ? 'True' : 'False' ?> - <?= $answer['ac_content'] ?></h3>           
<?php           } else {    ?>
                    <h3><?= $answer['ac_status'] == 1 ? 'True' : 'False' ?> - <?= $answer['ac_content'] ?></h3>
<?php           }
                if($count<count($userAnswer[$questionID]))
                    $count++;
            } else {
?>
                <h3><?= $answer['ac_status'] == 1 ? 'True' : 'False' ?> - <?= $answer['ac_content'] ?></h3>
<?php
            }
        }
    }
?>

</div>
