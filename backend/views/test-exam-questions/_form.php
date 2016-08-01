<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-exam-questions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'te_id')->textInput() ?>

    <?= $form->field($model, 'q_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
