<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

$this->registerJsFile('/res/js/plugins/bootstrap-markdown/editormd.min.js');
$this->registerCssFile('/res/css/plugins/editormd.min.css');
$this->registerCssFile('/res/css/paging.css', [], null);
/* @var $this yii\web\View */
/* @var $testExam backend\models\TestExam */

$this->title = ($testExam) ? $testExam->te_title : 'Not Found';
$this->params['breadcrumbs'][] = ['label' => 'Test Manager', 'url' => ['index']];
($testExam) ? $this->params['breadcrumbs'][] = $testExam->te_id : null;
?>

<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>

    <div class="ibox-content">
        <div class="hr-line-solid"></div>

        <?php if ($testExam) : ?>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>Code</th>
                            <td><?= $testExam->te_code ?></td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td><?= $category[$testExam->te_category] ?></td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td><?= $level[$testExam->te_level] ?></td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td><?= $testExam->te_title ?></td>
                        </tr>
                        <tr>
                            <th>Test Time</th>
                            <td><?= $testExam->te_time ?></td>
                        </tr>
                        <tr>
                            <th>Number of Questions</th>
                            <td><?= $testExam->te_num_of_questions ?></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td><?= $testExam->created_at ?></td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td><?= $testExam->updated_at ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="hr-line-solid"></div>
            <?php
            if ($questions_answers) {
                $form = ActiveForm::begin();
                $q_count = $start + 1;
                foreach ($questions_answers as $question) { ?>
                    <div style='background: #ebebe0' class='editormdCl m-b-md m-t-md' id='<?= $question->q_id ?>'></div>
                    <div class='hidden' id='<?= $question->q_id.'_hd' ?>'><?= Json::htmlEncode($question->q_content)?></div>
                <?php
                ++$q_count;
                    // Display answer of this question
                foreach ($question->answers as $answer) {
                    echo "- &nbsp;". htmlentities($answer->qa_content) ."&nbsp;";
                    echo ($answer->qa_status == 1) ? "<span class='label label-primary'>True</span>" : '';
                    echo "<br>";
                }
                }
                $form = ActiveForm::end();
            } else {
                echo '<h3>No question found</h3>';
            }
            ?>
            
            <?= $paging_html;?>
            
            <div class="hr-line-solid"></div>
            <?= Html::a('Edit', ['update', 'id' => $testExam->te_id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $testExam->te_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>

        <?php else : ?>
            <h3>Test not found</h3>
        <?php endif; ?>

        <?= Html::a('Back', ['/test-exam/index'], ['class' => 'btn btn-primary pull-right']) ?>
    </div>
</div>

<script>
$(function() {
    $(".editormdCl").each(function(idx, el) {
        var el_id = el.id;
        var editor = editormd(el_id, {
            width  : "100%",
            readOnly: true,
            watch: false,
            markdown        : JSON.parse($("#" + el_id + "_hd").html()),
            path : "/res/lib/", // Autoload modules mode, codemirror, marked... dependents libs path
        });
    });
});
</script>
