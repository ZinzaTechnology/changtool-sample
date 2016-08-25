<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\lib\components\AppConstant;

$this->title = 'Doing Test';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/res/js/plugins/dataTables/datatables.min.js', ['position' => static::POS_BEGIN]);
$this->registerJsFile('/res/js/fr/userTest_do.js', ['position' => static::POS_BEGIN]);
$this->registerCssFile('/res/css/plugins/dataTables/datatables.min.css');

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

<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget([ 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [ ] ])?>

        <div class="hr-line-dashed"></div>

        <h2 style='color:#e60000'>TIME LEFT: <span id="countdown"></span></h2>
    </div>

    <div class="ibox-content">
    <div class="hidden" id="timeCount"><?= $timeCount ?></div>
        <?= Html::beginForm(Url::toRoute('/user-test/submit'), 'post', ['class' => 'form-group','id' => 'testForm']); ?>
            <?= Html::hiddenInput('ut_id', $userTestData->ut_id) ?>
            <table class="table table-bordered" id="testTable">
                <thead>
                    <th>No.</th>
                    <th>Content</th>
                </thead>
                <tbody>
                    <?php foreach (array_keys($userTestData->question_clones) as $idx => $qc_id) : ?>
                        <?php $qu = $userTestData->question_clones[$qc_id]; ?>
                        <tr>
                            <td>Question <?= $idx + 1 ?></td>
                            <td>
                                <div style='background: #ebebe0' class='editormdCl m-b-md m-t-md' id='<?= $qu['qc_id'] ?>'></div>
                                <div class='hidden' id='<?= $qu['qc_id'] ?>_hd'><?= json_encode($qu['qc_content']) ?></div>
                                <?php if ($qu['qc_type'] == AppConstant::QUESTION_TYPE_SINGLE_ANSWER) : ?>
                                    <?php foreach ($qu['answers'] as $ans) : ?>
                                        <?= Html::radio("questions[$qc_id][]", false, [
                                            'value' => $ans['ac_id'],
                                            'id' => "q_{$qc_id}_{$ans['ac_id']}",
                                            'class' => 'i-checks']) ?>
                                        <?= Html::label($ans['ac_content'], "q_{$qc_id}_{$ans['ac_id']}") ?><br>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?php foreach ($qu['answers'] as $ans) : ?>
                                        <?= Html::checkbox("questions[$qc_id][]", false, [
                                            'value' => $ans['ac_id'],
                                            'id' => "q_{$qc_id}_{$ans['ac_id']}",
                                            'class' => 'i-checks']) ?>
                                        <?= Html::label($ans['ac_content'], "q_{$qc_id}_{$ans['ac_id']}") ?><br>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="hr-line-solid"></div>
            <?=  Html::submitButton('Submit', ['class' => 'btn btn-primary', "onclick" => 'testFormSubmit()'])  ?>
        
        <?php Html::endForm(); ?>
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
