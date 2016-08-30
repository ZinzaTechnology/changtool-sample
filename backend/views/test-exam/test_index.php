<?php
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;

$this->registerJsFile('/res/js/plugins/bootstrap-markdown/editormd.min.js');
$this->registerCssFile('/res/css/plugins/editormd.min.css');
$this->registerJsFile('/res/lib/marked.min.js');
$this->registerJsFile('/res/lib/prettify.min.js');
$this->registerJsFile('/res/lib/flowchart.min.js');
$this->registerJsFile('/res/lib/raphael.min.js');
$this->registerJsFile('/res/lib/underscore.min.js');
$this->registerJsFile('/res/lib/sequence-diagram.min.js');
$this->registerJsFile('/res/lib/jquery.flowchart.min.js');

$this->title = "TestExam $te_code: add questions";
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/res/js/paging.js', ['position' => \yii\web\View::POS_HEAD], null);
$this->registerCssFile('/res/css/paging.css', [], null);
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

        <?= $this->render('test_search', ['level' => $level, 'category' => $category, 'type' => $type, 'search_param' => $search_param]); ?>

        <div class="hr-line-solid"></div>

        <?php ActiveForm::begin([
                'action' => Url::toRoute(['/test-exam/update','id' => $id]),
                'method' => 'post',
        ]); ?>
        <table class="table table-hover" id="results">
            <caption>QUESTION</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question ID</th>
                    <th>Category</th>
                    <th>Level</th>
                    <th>Type</th>
                    <th>Content</th>
                    <th>Created date</th>
                    <th>Updated date</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($questions as $question) : ?>
                    <tr>
                        <td><?= '<input type="checkbox" name="option[]" value="'.$question->q_id.'" '.(in_array($question->q_id, $all_questions) ? 'checked disabled readonly' : '').' />'; ?></td>
                        <td><?= $question->q_id ?></td>
                        <td><?= $category ?></td>
                        <td><?= $level[$question->q_level] ?></td>
                        <td><?= $type[$question->q_type] ?></td>
                        <td>
                            <div class='editormdCl' id='<?= $question->q_id?>'></div>
                            <div class='hidden' id='<?= $question->q_id ?>_hd'><?= Json::htmlEncode($question->q_content) ?></div>
                        </td>
                        <td><?= $question->created_at ?></td>
                        <td><?= $question->updated_at ?></td>
                        <td><?= Html::a('View', ['/question/view', 'q_id' => $question->q_id], ['class' => 'btn btn-warning']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="pageNavPosition"></div>
        <div class="hr-line-solid"></div>
        <?= Html::submitButton('Add', ['name' => 'te_update', 'value' => 'add_question_complete', 'class' => 'btn btn-primary']) ?>
        <?= Html::a('Back', ['/test-exam/update?id='.$id], ['class' => 'btn btn-primary pull-right']) ?>
        <?php ActiveForm::end(); ?>
        <script type="text/javascript">
            var pager = new Pager('results', <?= $pagging_size ?>); 
            pager.init(); 
            pager.showPageNav('pager', 'pageNavPosition'); 
            pager.showPage(1);
        </script>
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
