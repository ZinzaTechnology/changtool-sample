<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->registerJsFile('/res/js/plugins/bootstrap-markdown/editormd.min.js');
$this->registerCssFile('/res/css/plugins/editormd.min.css');
$this->registerJsFile('/res/lib/marked.min.js');
$this->registerJsFile('/res/lib/prettify.min.js');
$this->registerJsFile('/res/lib/flowchart.min.js');
$this->registerJsFile('/res/lib/raphael.min.js');
$this->registerJsFile('/res/lib/underscore.min.js');
$this->registerJsFile('/res/lib/sequence-diagram.min.js');
$this->registerJsFile('/res/lib/jquery.flowchart.min.js');

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */

$this->title = $tile;
$this->params['breadcrumbs'][] = ['label' => 'User Test', 'url' => Url::toRoute('/user-test')];
$this->params['breadcrumbs'][] = $this->title;
$question_count = ($page - 1) * $limitQuestion + 1;
?>

<div class="ibox">
    <div class="ibox-title m-b-md">
        <h1><?= Html::encode($this->title) ?></h1>
        <?=
        Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])
        ?>
    </div>
    <div class="ibox-content">
        <div class="OK"></div>
        <div id="content">
            <?php if (count($data)) : ?>
                <?php foreach ($data as $question) : ?>
                    <div class="element">
                        <label class="control-label"><?= "Question {$question_count}" ?></label>
                        <div class="alert alert-info">
                            <strong><?= $question['qc_content'] ?></strong>
                        </div>
                        <div class="m-b-md">
                            <?php foreach ($question['answer'] as $answer) : ?>
                                <?php $checked = (isset($userAnswer["question-{$answer['qc_id']}"]) && in_array($answer['ac_id'], $userAnswer["question-{$answer['qc_id']}"])) ? true : false; ?>
                                <div class="i-checks">
                                    <?= Html::checkbox('answer', $checked, ['disabled' => '']) ?>
                                    <?= $answer['ac_content'] ?>
                                    <?= ($answer['ac_status'] == 1) ? "<span class='label label-primary'>True</span>" : '' ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php $question_count++; ?>
                    </div>
                <?php endforeach; ?>
                <div class="form-group">
                    <?= Html::a('Previous', ($page - 1 > 0) ? Url::current(['page' => $page - 1]) : '', ['class' => 'btn btn-default', 'disabled' => ($page - 1 > 0) ? false : true]) ?>
                    <?= Html::a('Next', ($page < $pageMax) ? Url::current(['page' => $page + 1]) : '', ['class' => 'btn btn-default', 'disabled' => ($page < $pageMax) ? false : true]) ?>
                </div>
            <?php else : ?>
                <strong>No question found</strong>"
            <?php endif; ?>

        </div>
    </div>
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
