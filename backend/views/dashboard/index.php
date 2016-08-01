<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Dashboard';
?>
<div class="site-index">
	<?= Html::a('Test Exam Manager', ['../ba/test-exam'], ['class' => 'btn btn-success'])?>
	<?= Html::a('User Manager', ['../ba/user'], ['class' => 'btn btn-success'])?>
	<?= Html::a('User Test Manager', ['../ba/user_test'], ['class' => 'btn btn-success'])?>
	<?= Html::a('Question Manager', ['../ba/question'], ['class' => 'btn btn-success'])?>
</div>
