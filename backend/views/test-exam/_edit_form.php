<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\controllers\GlobalVariableControllser;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */
/* @var $form yii\widgets\ActiveForm */

include 'site.php';

?>
<div class="test-exam-form">

    <?php $form = ActiveForm::begin(); ?>
    
<div class="test_exam">
	<div class="info">
		<b>TestExam Information.</b>
	</div>
	<div class="te_code">
		<div class="te_code_title"><b>Test Exam Code:</b></div>
		<div class="te_code_content"><?= $form->field($model, 'te_code')->textinput(['style'=>'width:150px'])->label(false); ?></dev>
	</div>
	<div>
		<b>Test Exam Category:</b>
		<?php 
		    echo $form->field($model, 'te_category')->widget(Select2::classname(), [
	    		'data' => ArrayHelper::map($category,'id','name'),
	    		'options' => ['placeholder' => 'Select a state ...'],
	    		'pluginOptions' => [
	    			'allowClear' => true,
	    			'width' => '150px'
	    		],
	    	])->label(false);
		?>
	</div><div>
		<b>Test Exam Level:</b>
		<?php 
		    echo $form->field($model, 'te_level')->widget(Select2::classname(), [
	    		'data' => ArrayHelper::map($level,'id','name'),
	    		'options' => ['placeholder' => 'Select a state ...'],
	    		'pluginOptions' => [
	    			'allowClear' => true,
	    			'width' => '150px',
	    			
	    		],
	    	])->label(false);
		?>
		
	</div><div>
		<div><b>Title of Test Exam: </b></div>
		<div><?= $form->field($model, 'te_title')->textinput(['style'=>'width:150px'])->label(false); ?></dev>
	</div><div>
		<div><b>Time to do Test Exam:</b></div>
		<div><?= $form->field($model, 'te_time')->textinput(['style'=>'width:150px'])->label(false); ?></dev>
	</div><div>
		<div><b>Number of questions in this Exam: </b></div>
		<div><?php echo $model->te_num_of_questions; ?></div>
	</div><div>
		<div><b>Test Exam is created at: </b></div>
		<div><?php echo $model->te_created_at; ?></div>
	</div>
	<div>
		<div><b>Test Exam is updated at: </b></div>
		<div><?php echo $model->te_last_updated_at; ?></div>
</div>

<?= Html::a('Add Question', ['create'], ['class' => 'btn btn-success']) ?>

<?php
	$q_count = 1;
	foreach($questions as $q)
	{
		echo $form->field($q,'q_content')->textarea(['style'=>'height: 200px'])->label("Question $q_count");

		echo Html::a("Delete Question $q_count", ['deleteq','te_id' => $model->te_id, 'q_id' => $q['q_id']], [
				'class' => 'btn btn-danger',
				'data' => [
						'confirm' => 'Are you sure you want to delete this item?',
						'method' => 'post',
				],
		]);
		
		++$q_count;
	}
?>
    <div class="form-group" align="right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
