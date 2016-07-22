<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserTest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-test-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'u_id')->textInput() ?>

    <?= $form->field($model, 'te_id')->textInput() ?>

    <?= $form->field($model, 'ut_status')->dropDownList([ 'ASSIGNED' => 'ASSIGNED', 'DOING' => 'DOING', 'DONE' => 'DONE', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ut_mark')->textInput() ?>

    <?= $form->field($model, 'ut_start_at')->textInput() ?>

    <?= $form->field($model, 'ut_finished_at')->textInput() ?>

    <?= $form->field($model, 'ut_question_clone_ids')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ut_user_answer_ids')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
