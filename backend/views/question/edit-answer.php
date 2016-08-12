<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = "Edit Answer";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ibox">
	<div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>

 <div class="hr-line-solid"></div>

<?php $form= ActiveForm :: begin(['action' =>['question/edit-answer'], 'id' => 'form_edit_answer', 'method' => 'post',])?>
<?= $form ->field($answer,'qa_content')->textArea(['placeholder'=>'input question ?','row'=>'10']) ?>
<?= $form->field($question, 'qa_status')->radioList( $level); ?>
<hr width=300px align="left"/>
<?php echo Html::a('Back', ['/question/index'],['class'=>'btn btn-success']);?>
<?= Html::submitButton('Create',['class'=> 'btn btn-success']) ?>
<?php ActiveForm :: end()?>
</div>