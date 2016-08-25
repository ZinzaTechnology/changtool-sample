<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$this->registerJsFile('/res/js/plugins/bootstrap-markdown/editormd.min.js');
$this->registerCssFile('/res/css/plugins/editormd.min.css');
$this->registerJsFile('/res/lib/marked.min.js');
$this->registerJsFile('/res/lib/prettify.min.js');
$this->registerJsFile('/res/lib/flowchart.min.js');
$this->registerJsFile('/res/lib/raphael.min.js');
$this->registerJsFile('/res/lib/underscore.min.js');
$this->registerJsFile('/res/lib/sequence-diagram.min.js');
$this->registerJsFile('/res/lib/jquery.flowchart.min.js');

?>

<div class="test-exam-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <!-- Test information udpate area -->
    <div class="test_exam">
        <div class="info">
            <b>TestExam Information.</b>
        </div>

        <div class="row">
            <div class="col-md-9">
                <table class="table table-bordered">
                    <tr>
                        <td>
                        <?= $form->field($testExam, 'te_category')->widget(Select2::classname(), [
                                'data' => $test_category,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select Category ...'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]);
                        ?>
                        </td>
                        <td>
                        <?= $form->field($testExam, 'te_level')->widget(Select2::classname(), [
                                'data' => $test_level,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select a Level ...'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]);
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <?= $form->field($testExam, 'te_code')
                            ->textInput()
                            ->hint('Input the code of this exam');?>
                        </td>
                        <td>
                        <?= $form->field($testExam, 'te_title')
                            ->textInput()
                            ->hint('Input the title of this exam');?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <?= $form->field($testExam, 'te_time')
                            ->textInput(['type' => 'number'])
                            ->hint('Input time to do this exam (in minutes)');?>
                        </td>
                        <td>
                        <?= $form->field($testExam, 'te_num_of_questions')
                            ->textInput(['type' => 'number', 'disabled' => true])
                            ->hint('Input number question of this exam');?>
                        </td>
                    </tr>
                </table>
                <div class="hr-line-solid"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Add Question', ['name' => 'te_update', 'value' => 'add_question', 'class' => 'btn btn-primary']) ?>
                <div class="hr-line-dashed"></div>
            </div>

            <div class="col-md-9">
                <?php
                $q_count = $start + 1;
                foreach ($all_questions as $aq) {
                    echo '<div class="row">';
                    echo '<div class="col-md-9">';
                    echo "<label class='col-md-4'>";
                    echo "Question $q_count (q_id: $aq->q_id)";
                    echo '</label>';
                    echo '<div style="background: #ebebe0" class="editormdCl m-b-md m-t-md" id="'.$aq->q_id.'"></div>';
                    echo "<div class='hidden' id='{$aq->q_id}_hd'>".Json::htmlEncode($aq->q_content)."</div>";
                    echo '</div>';
                    echo '<div class="col-md-3" style="padding-top: 20px">';
                    echo Html::a("Delete Question $q_count", ['deleteq','te_id' => $testExam->te_id, 'q_id' => $aq['q_id']], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]);
                    echo '</div>';
                    echo '</div>';

                    ++$q_count;
                }
                ?>
           </div> 
        </div>
        
        <?= $paging_html; ?>
        
        <div class="hr-line-solid"></div>
        <?= Html::submitButton('Cancel', ['name' => 'te_update', 'value' => 'cancel',
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to cancel this update?',]
        ]) ?>
        <?= Html::submitButton('Update', ['name' => 'te_update', 'value' => 'update', 'class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div>

<script>
$(function() {
    $(".editormdCl").each(function(idx, el) {
        var el_id = el.id;
        editormd.markdownToHTML(el.id, {
            markdown        : JSON.parse($("#" + el_id + "_hd").html()),
            //htmlDecode      : true,
            htmlDecode      : "style,script,iframe",  // you can filter tags decode
            //toc             : false,
            tocm            : true,    // Using [TOCM]
            //tocContainer    : "#custom-toc-container", 
            //gfm             : false,
            //tocDropdown     : true,
            // markdownSourceCode : true, 
            emoji           : true,
            taskList        : true,
            tex             : true,  
            flowChart       : true,  
            sequenceDiagram : true,  
        });
    });

});
</script>
