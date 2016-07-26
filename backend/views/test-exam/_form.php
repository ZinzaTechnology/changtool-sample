<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-exam-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'te_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'te_category')->textInput() ?>

    <?= $form->field($model, 'te_level')->textInput() ?>

    <?= $form->field($model, 'te_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'te_time')->textInput() ?>

    <?= $form->field($model, 'te_num_of_questions')->textInput() ?>

    <?= $form->field($model, 'te_created_at')->textInput() ?>

    <?= $form->field($model, 'te_last_updated_at')->textInput() ?>

    <?= $form->field($model, 'te_is_deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
