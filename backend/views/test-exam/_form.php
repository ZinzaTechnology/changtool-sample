<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\controllers\GlobalVariableControllser;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-exam-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="auto_create">
		<div align="left">
			<?php
				echo $form->field($model, 'te_category')->widget(Select2::classname(), [
		    		'data' => ArrayHelper::map($category,'id','name'),
		    		'language' => 'en',
		    		'options' => ['placeholder' => 'Select Category ...'],
		    		'pluginOptions' => [
		    			'allowClear' => true,
		    			'width' =>'150px',
		    		],
		    	]);
			?>
		</div>
		<div align="left">
			<?php
				echo $form->field($model, 'te_level')->widget(Select2::classname(), [
		    		'data' => ArrayHelper::map($level,'id','name'),
		    		'language' => 'en',
		    		'options' => ['placeholder' => 'Select a Level ...'],
		    		'pluginOptions' => [
		    			'allowClear' => true,
		    			'width' =>'150px',
		    		],
		    	]);
			?>
		</div>
		<div align="left">
		    <?php //$list = [0 => 'Auto create', 1 => 'Manual Create'];
			 	//echo $form->field($model, 'te_category')->radioList($list)->label('How to create test exam'); 
			 ?>
		</div>
		<div align="left">
	    	<?php echo $form->field($model, 'te_code')
	    		->textInput(['style'=>'width:150px'])
	    		->hint('Input the code of this exam');?>
		</div>
		<div align="left">
		    <?php echo $form->field($model, 'te_title')
		    	->textInput(['style'=>'width:150px'])
		    	->hint('Input the title of this exam');?>
		</div>
		<div align="left">
		    <?php echo $form->field($model, 'te_time')
		    	->textInput(['style'=>'width:150px'])
		    	->hint('Input time to do this exam');?>
		</div>
		<div align="left">
		    <?php echo $form->field($model, 'te_num_of_questions')
		    	->textInput(['style'=>'width:150px'])
		    	->hint('Input number question of this exam');?>
	    </div>
	</div>
	    
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
