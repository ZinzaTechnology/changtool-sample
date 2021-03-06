<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ibox">
    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(); ?>
        
            <?= $form->field($model, 'u_fullname')->textInput(['maxlength' => true]) ?>   
        
            <?= $form->field($model, 'u_mail')->textInput(['maxlenght' => true, 'placeholder' => 'Optional']) ?>  
        
            <?= $form->field($model, 'u_role')->dropDownList([ 'ADMIN' => 'ADMIN', 'USER' => 'USER', ]) ?> 
            
            <?= Html::a('Change password', Url::toRoute(['changepassword','id' => $model->u_id])) ?>
            
            <div class="hr-line-solid"></div>
            
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Done', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->u_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => "Are you sure you want to delete account $model->u_name?",
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('Cancel', ['/user/index'], ['class' => 'btn btn-primary grid-button']) ?>
            </div>
        
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
