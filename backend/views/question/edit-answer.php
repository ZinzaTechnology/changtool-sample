<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = "Edit Answer";
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="ibox">
	<div class="ibox-title">
		<h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ] ] )?>
    </div>

	<div class="hr-line-solid"></div>

<?php $form= ActiveForm :: begin(['action' =>['question/edit-answer'], 'id' => 'form_edit_answer', 'method' => 'post',])?>
<?= $form ->field($answer,'qa_content')->textArea(['placeholder'=>'input Answer ?','row'=>'10'])?>
<?= $form->field($answer, 'qa_status')->checkbox(); ?>
<div class="hr-line-solid"></div>
<?php echo Html::a('Back', ['/question/view','q_id' => $q_id],['class'=>'btn btn-success']);?>
<?= Html::submitButton('Update',['class'=> 'btn btn-success'])?>
<?php ActiveForm :: end()?>
</div>