<?php 

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Change Password for: ' . $model->u_name;

?>

<style>
	
</style>

<div class="site-changepassword">
    <h1><?= Html::encode($this->title) ?></h1>
     
    <?php $form = ActiveForm::begin([
        'id'=>'changepassword-form',
        'options'=>['class'=>'form-horizontal'],
        'fieldConfig'=>[
            'template'=>"{label}\n<div class=\"col-lg-4\">
                        {input}</div>\n<div class=\"col-lg-5\">
                        {error}</div>",
            'labelOptions'=>['class'=>'col-lg-2 control-label'],
        ],
    ]); ?>
    
         <?= $form->field($model,'u_password_hash',['inputOptions'=>[
            'placeholder'=>'New Password'
        ]])->passwordInput(['value' => '']) ?>
        
        <?= $form->field($model,'confirm_pwd_update',['inputOptions'=>[
            'placeholder'=>'Repeat New Password'
        ]])->passwordInput(['required' => true]) ?>
        
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-11">
                <?= Html::submitButton('Done',[
                    'class'=>'btn btn-primary'
                ]) ?>
                <?= Html::a('Cancel', ['/user/index'], ['class' =>'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>