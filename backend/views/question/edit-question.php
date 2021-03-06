<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = "Update Question";
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/res/js/plugins/bootstrap-markdown/editormd.min.js');
$this->registerCssFile('/res/css/plugins/editormd.min.css');
?>
<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget([ 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [ ] ])?>
    </div>
    <br>

    <?php $form = ActiveForm :: begin(['action' => ['question/execute-edit'], 'id' => 'form_edit', 'method' => 'post',])?>
        <div class="ibox-content">
            <?php // $form ->field($question, 'q_content')->textArea(['placeholder' => 'input question ?','row' => '15','style'=>'resize'])?>

            <div id="editormd">
                <textarea class="editormd-markdown-textarea" name="Question[q_content]"><?= $question['q_content']?></textarea>
                <textarea class="editormd-html-textarea" name="Question[q_content_html]"></textarea>
            </div>
            <?= $form->field($question, 'q_category')->dropDownList($category, ['prompt' => '---Select---']); ?>
            <?= $form->field($question, 'q_level')->radioList($level); ?>
            <?= $form->field($question, 'q_type')->radioList($type); ?>
            <?= $form->field($question, 'q_id')->hiddenInput(['value' => $question->q_id])->label(false);?>
            <hr width=100%px align="left" />

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        <i class="glyphicon glyphicon-envelope"></i> Answer
                    </h4>
                </div>
                <div class="panel-body">   
                    <?php
                    DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $answers[0],
                        'formId' => 'form_edit',
                        'formFields' => [
                            'qa_id',
                            'qa_content',
                            'qa_status'
                        ]
                    ]);
                    ?>
                        <!-- widgetContainer -->
                        <div class="container-items">
                            <?php foreach ($answers as $i => $answer) :  ?>
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
                                        <?= Html::activeHiddenInput($answer, "[{$i}]qa_id"); ?>
                                        <?= $form->field($answer, "[{$i}]qa_content")->textInput(['maxlength' => true])?>
                                        <?= $form->field($answer, "[{$i}]qa_status")->checkbox(); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php DynamicFormWidget::end(); ?>
                 </div>
            </div>
        </div>
        <div class="ibox-content">
            <?= Html::submitButton('Update', ['class' => 'btn btn-success'])?>
            <?php echo Html::a('Back', ['/question/index'], ['class' => 'btn btn-primary pull-right']);?>
        </div>
    <?php ActiveForm :: end()?>
    <br>
</div>

<script type="text/javascript">
$(function() {
    var editor = editormd("editormd", {
    width  : "100%",
        height : 300,
        path : "/res/lib/", // Autoload modules mode, codemirror, marked... dependents libs path
    });
});
</script>
