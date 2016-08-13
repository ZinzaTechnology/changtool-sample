<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'u_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'u_mail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'u_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'u_password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'u_password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'u_auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'u_role')->dropDownList([ 'ADMIN' => 'ADMIN', 'USER' => 'USER', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'u_created_at')->textInput() ?>

    <?= $form->field($model, 'u_updated_at')->textInput() ?>

    <?= $form->field($model, 'u_is_deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
