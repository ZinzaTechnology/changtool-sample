<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = "Create Question";
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="ibox">
	<div class="ibox-title">
		<h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ] ] )?>
    </div>

	<div class="hr-line-solid"></div>
 
<?php $form= ActiveForm :: begin(['action' =>['question/create'], 'id' => 'form_create', 'method' => 'post',])?>
<?= $form ->field($question,'q_content')->textArea(['placeholder'=>'input question ?','row'=>'10'])?>
<?php echo $form->field($question, 'q_category')->dropDownList($category,['prompt'=>'---Select---']); ?>
<?= $form->field($question, 'q_level')->radioList( $level); ?>
<?= $form->field($question, 'q_type')->radioList($type); ?>
<hr width=300px align="left" />


	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>
				<i class="glyphicon glyphicon-envelope"></i> Answer
			</h4>
		</div>
		<div class="panel-body">   
   <?php

DynamicFormWidget::begin ( [ 
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $answer [0],
    'formId' => 'form_create',
    'formFields' => [ 
        'qa_content',
        'qa_status' 
    ] 
]
 );
?>

            <div class="container-items">
				<!-- widgetContainer -->
            <?php foreach ($answer as $i => $answer): ?>
                <div class="item panel panel-default">
					<!-- widgetBody -->
					<div class="panel-heading">
						<h3 class="panel-title pull-left">Answer</h3>
						<div class="pull-right">
							<button type="button" class="add-item btn btn-success btn-xs">
								<i class="glyphicon glyphicon-plus"></i>
							</button>
							<button type="button" class="remove-item btn btn-danger btn-xs">
								<i class="glyphicon glyphicon-minus"></i>
							</button>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-body">
                       
                        <?= $form->field($answer, "[{$i}]qa_content")->textInput(['maxlength' => true])?>
                       <?= $form->field($answer, "[{$i}]qa_status")->checkbox(); ?>
                       
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
		 </div>
		</div>





<hr width=300px align="left" />



	</div>
	<div class="hr-line-solid"></div>
<?php echo Html::a('Back', ['/question/index'],['class'=>'btn btn-success']);?>
<?= Html::submitButton('Create',['class'=> 'btn btn-success'])?>
<?php ActiveForm :: end()?>

		