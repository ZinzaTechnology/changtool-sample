<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Exams';
?>

<div class="test-exam-index">
	
    <h1><?= Html::encode($this->title) ?></h1>

   
    	    
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'u_name')->textArea() ?>
	<?php ActiveForm::end(); ?>
    
</div>
