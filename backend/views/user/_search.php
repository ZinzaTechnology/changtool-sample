<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="user-search">

<div class="row">
<div class="col-lg-3">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    
    <?= $form->field($model, 'globalSearch') ?>
    
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
        
    </div>      
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
