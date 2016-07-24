<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\ActiveField;
use yii\data\Pagination;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Exam';

?>
<div class="user-test-index">
	<h3>Language : </h3>
	
	
    <h4><?= Html::encode($this->title) ?></h4>
     <?php $form = ActiveForm::begin(['action' => 'test/index', 'id' => 'forum_post', 'method' => 'post',]); ?>
    <?= $form->field($model, 'te_id')->textArea() ?>
    <?php ActiveForm::end(); ?>
    
    
    
   
	
	 <div style="display: inline-block; width: 100%">
	<div style="float:left">	
		    <?php echo $form->field($model, 'te_id')
		    	->textInput(['style'=>'width:300px;float:left;margin-top:30px'])
		    	
		    	?>
	<input type="checkbox" name="Answer-1" id="answer_1" value="value" style="height:33px;width:33px;margin-top:-10px">
	<label for="answer_1"></label>		    	
		    	</div>
	<div style="float:right;">
		    <?php echo $form->field($model, 'te_id')
		    	->textInput(['style'=>'width:300px;margin-right:33px'])
		    	?>
	<input type="checkbox" name="Answer-2" id="answer_2" value="value" style="height:33px;width:33px;margin-top:-50px;float:right">
   	<label for="answer_2"></label>  	
	    </div>
	    </div>
	<div style="float:left">
		    <?php echo $form->field($model, 'te_id')
		    	->textInput(['style'=>'width:300px;float:left;margin-top:30px'])
		    	?>
    <input type="checkbox" name="Answer-3" id="answer_3" value="value" style="height:33px;width:33px;margin-top:-10px">
   	<label for="answer_3"></label>
		    	
	    </div>
	<div style="float:right;">
		    <?php echo $form->field($model, 'te_id')
		    	->textInput(['style'=>'width:300px;margin-right:33px'])
		    	?>
	<input type="checkbox" name="Answer-4" id="answer_4" value="value" style="height:33px;width:33px;margin-top:-50px;float:right">
   	<label for="answer_4"></label>  		    	
	    </div>
	    
	
	<div		
	<div style="width:230px;height:60px;margin-left:0px;margin-top: 270px">
	<div style='margin:0 auto 0;'><?= Html::a('Summit',['/test'],['class'=>'btn btn-success'])?></div>
	</div>
	</div>	
	 
</div>