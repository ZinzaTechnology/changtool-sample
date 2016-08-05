<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */

$this->title = $model->te_id;
$this->params['breadcrumbs'][] = ['label' => 'Test Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="test-exam-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->te_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->te_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	<div>
	<?php 
		$text_width = 300;
	?>
		<div style="float:left; width:<?=$text_width.'px';?>">Test Exam Code:</div>
		<div style="color:red;"><b><?php echo $model->te_code; ?></b></div>
	</div>
	<div>
		<div style="float:left; width:<?=$text_width.'px';?>">Test Exam Category:</div>
		<div style="color:red;"><b><?php echo $category_name; ?></b></div>
	</div><div>
		<div style="float:left; width:<?=$text_width.'px';?>">Test Exam Level:</div>
		<div style="color:red;"><b><?php echo $level_name; ?></b></div>
	</div><div align="justify">
		<div style="float:left; width:<?=$text_width.'px';?>">Title of Test Exam:</div>
		<div style="color:red;"><b><?php echo $model->te_title; ?></b></div>
	</div><div>
		<div style="float:left; width:<?=$text_width.'px';?>">Time to do Test Exam:</div>
		<div style="color:red;"><b><?php echo ($model->te_time/60)."minutes"; ?></b></div>
	</div><div>
		<div style="float:left; width:<?=$text_width.'px';?>">Number of questions in this Exam:</div>
		<div style="color:red;"><b><?php echo $model->te_num_of_questions; ?></b></div>
	</div><div>
		<div style="float:left; width:<?=$text_width.'px';?>">Test Exam is created at:</div>
		<div style="color:red;"><b><?php echo $model->te_created_at?$model->te_created_at:'Not Set';?></b></div>
	</div>
	<div>
		<div style="float:left; width:<?=$text_width.'px';?>">Test Exam is updated at:</div>
		<div style="color:red;"><b><?php echo $model->te_last_updated_at?$model->te_last_updated_at:'Not Set'; ?></b></div>
	</div>

<?php
$form = ActiveForm::begin();
	$q_count = 1;
	foreach($questions as $q)
	{
		echo $form->field($q,'q_content')->textarea(['style'=>'height: 200px', 'readonly'=>true])->label("Question $q_count");
		++$q_count;
	}
	$form = ActiveForm::end();
?>
</div>
