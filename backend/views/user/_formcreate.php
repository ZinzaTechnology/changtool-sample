<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="ibox">
    <div class="user-form">
        <div class="row">
            <div class="col-lg-6">
                <?php $form = ActiveForm::begin([
                    'enableAjaxValidation' => true,
                    'validationUrl' => 'validate',
                ]); ?>
    
                <?= $form->field($model, 'u_name')->textInput(['maxlength' => true]) ?>
    
                <?= $form->field($model, 'u_fullname')->textInput(['maxlength' => true]) ?>
    
                <?= $form->field($model, 'u_password_hash')->passwordInput(['maxlength' => true]) ?>
    
                <?= $form->field($model, 'confirm_pwd_create')->passwordInput(['maxlength' => true,'required' => true]) ?>
    
                <?= $form->field($model, 'u_mail')->textInput(['maxlength' => true]) ?>
    
                <?= $form->field($model, 'u_role')->dropDownList(
                    ['ADMIN' => 'ADMIN', 'USER' => 'USER',],
                    [
                        'prompt' => '',
                        'options' => [
                            'USER' => ['Selected' => true]
                        ]
                    ]
                )
                ?>
    
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Done' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    
                    <?= Html::a('Cancel', ['/user/index'], ['class' => 'btn btn-primary grid-button']) ?>
                </div>
            </div>
        </div>
    </div>
</div>