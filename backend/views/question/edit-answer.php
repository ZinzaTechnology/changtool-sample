<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = "Edit Answer";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget([ 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []])?>
    </div>
	<br>
    <div class="ibox-content">
    <?php $form = ActiveForm :: begin(['action' => ['question/edit-answer'], 'id' => 'form_edit_answer', 'method' => 'post',])?>
        <?= $form ->field($answer, "qa_content")->textArea(['placeholder' => 'input answer ?','row' => '15','style'=>'resize'])?>
        <?= $form->field($answer, 'qa_status')->checkbox(); ?>
        <?=  $form->field($answer, 'q_id')->hiddenInput(['value' => $q_id])->label(false);?>
        <?=  $form->field($answer, 'qa_id')->hiddenInput(['value' => $qa_id])->label(false);?>
     </div>
     <br>
     <div class="ibox-content">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success'])?>
    	<?php ActiveForm :: end()?>
    	<?php echo Html::a('Back', ['/question/view','q_id' => $q_id], ['class' => 'btn btn-primary pull-right']);?>
	</div>
</div>
