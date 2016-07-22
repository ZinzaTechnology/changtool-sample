<?php
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */


$this->title = 'Test Ability';
?>
<div class="site-index">
	<h2>Time : 30 min.</h2><br>
	<h2>Question number: 30.</h2><br>
		
<div style="width:250px;height:250px;float:left">
	<div style="width:90%;height:140%;border: 4px solid #000">PHP</div>
	<div style="margin:0 auto 0;"><?= Html::a('Start',['/user-test'],['class'=>'btn btn-success'])?></div>
</div>

<div style="width:250px;height:250px;float:Left">
	<div style="width:90%;height:140%;border: 4px solid #000">C#</div>
	<div style="margin:0 auto 0;"><?= Html::a('Start',['/user-test'],['class'=>'btn btn-success'])?></div>
</div>
<div style="width:250px;height:250px;float:left">
	<div style="width:90%;height:140%;border: 4px solid #000">C/C++</div>
	<div style="margin:0 auto 0;"><?= Html::a('Start',['/user-test'],['class'=>'btn btn-success'])?></div>
</div>
<div style="width:250px;height:250px;float:Left">
	<div style="width:90%;height:140%;border: 4px solid #000">JAVA</div>
	<div style="margin:0 auto 0;"><?= Html::a('Start',['/user-test'],['class'=>'btn btn-success'])?></div>
</div>

  
</div>

