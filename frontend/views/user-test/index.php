<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\ActiveField;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Exam';

?>
<div class="user-test-index">
	<h3>Language : </h3>
	
	
    <h1><?= Html::encode($this->title) ?></h1>
     <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'ut_id')->textArea() ?>
    <?php ActiveForm::end(); ?>
    
    <div
    <div style="width:400px;height:30px;float:Left;">
	<div style="width:90%;height:140%;border: 2px solid #000">
    <input type="checkbox" onclick="checked()" style="width:33px;height:33px;float:Left;margin-left:370px"/>
	</div>
	</div>
	
	<div
    <div style="width:400px;height:30px;float:Right;">
	<div style="width:90%;height:140%;border: 2px solid #000">
    <input type="checkbox" onclick="checked()" style="width:33px;height:33px;float:Left;margin-left:370px"/>
	</div>
	</div>
	
	<div
    <div style="width:400px;height:30px;float:Left;margin-top:20px">
	<div style="width:90%;height:140%;border: 2px solid #000">
    <input type="checkbox" onclick="checked()" style="width:33px;height:33px;float:Left;margin-left:370px"/>
	</div>
	</div>
	
	<div
    <div style="width:400px;height:30px;float:Right;margin-top:20px">
	<div style="width:90%;height:140%;border: 2px solid #000">
    <input type="checkbox" onclick="checked()" style="width:33px;height:33px;float:Left;margin-left:370px"/>
	</div>
	</div>
	
	
	
	
	
	
   </div>
    </div>
