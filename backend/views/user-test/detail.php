<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\lib\components\AppConstant;
/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */

$this->title = $tile;
$this->params['breadcrumbs'][] = ['label' => 'User Test', 'url' => Url::toRoute('/user-test')];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/res/js/plugins/dataTables/datatables.min.js', ['position' => static::POS_BEGIN]);
$this->registerCssFile('/res/css/plugins/dataTables/datatables.min.css');

$this->registerCssFile('/res/css/plugins/editormd.min.css');
$this->registerJsFile('/res/lib/marked.min.js');
$this->registerJsFile('/res/lib/prettify.min.js');
$this->registerJsFile('/res/lib/flowchart.min.js');
$this->registerJsFile('/res/lib/raphael.min.js');
$this->registerJsFile('/res/lib/underscore.min.js');
$this->registerJsFile('/res/lib/sequence-diagram.min.js');
$this->registerJsFile('/res/lib/jquery.flowchart.min.js');
$this->registerJsFile('/res/js/plugins/bootstrap-markdown/editormd.min.js');
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#testTable').DataTable({
        sort: false,
    });
});
</script>
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
        <table class="table table-bordered" id="testTable">
            <thead>
            <th>No.</th>
            <th>Content</th>
            </thead>
            <tbody>
                <?php foreach (array_keys($userTestData->question_clones) as $idx => $qc_id) : ?>
                    <?php $qu = $userTestData->question_clones[$qc_id]; ?>
                    <tr>
                        <td class="text-center">Question <?= $idx + 1 ?></td>
                        <td>
                            <div style='background: #F5F5F6' class="editormdCl m-b-xs" id="<?= $qu['qc_id']  ?>"></div>
                            <div class="hidden" id="<?= $qu['qc_id'].'_hd' ?>"><?= json_encode($qu['qc_content']) ?></div>
                            <?php if(isset($qu['answers'])): ?>
                                <?php if ($qu['qc_type'] == AppConstant::QUESTION_TYPE_SINGLE_ANSWER) : ?>
                                    <?php foreach ($qu['answers'] as $ans) : ?>
                                        <?=
                                        Html::radio("questions[$qc_id][]", isset($userAnswer[$qc_id][$ans['ac_id']])? true : false, [
                                            'class' => 'i-checks',
                                            'disabled' => true])
                                        ?>
                                        <?= Html::label($ans['ac_content'], "q_{$qc_id}_{$ans['ac_id']}") ?>
                                        <?php if($ans['ac_status']==1): ?>
                                            <span class="label label-primary">True</span>
                                        <?php endif; ?>
                                        <br>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?php foreach ($qu['answers'] as $ans) : ?>
                                        <?=
                                        Html::checkbox("questions[$qc_id][]", isset($userAnswer[$qc_id][$ans['ac_id']])? true : false, [
                                            'class' => 'i-checks',
                                            'disabled' => true])
                                        ?>
                                        <?= Html::label($ans['ac_content'], "q_{$qc_id}_{$ans['ac_id']}") ?>
                                        <?php if($ans['ac_status']==1): ?>
                                            <span class="label label-primary">True</span>
                                        <?php endif; ?>
                                        <br>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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