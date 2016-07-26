<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-exam-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'te_id') ?>

    <?= $form->field($model, 'te_code') ?>

    <?= $form->field($model, 'te_category') ?>

    <?= $form->field($model, 'te_level') ?>

    <?= $form->field($model, 'te_title') ?>

    <?php // echo $form->field($model, 'te_time') ?>

    <?php // echo $form->field($model, 'te_num_of_questions') ?>

    <?php // echo $form->field($model, 'te_created_at') ?>

    <?php // echo $form->field($model, 'te_last_updated_at') ?>

    <?php // echo $form->field($model, 'te_is_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
