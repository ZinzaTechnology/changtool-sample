<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\lib\components\AppConstant;

$this->title = 'Doing Test';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget([ 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [ ] ])?>

        <div class="hr-line-dashed"></div>

        <h2 style='color:#e60000'>TIME LEFT: <span id="countdown"></span></h2>
    </div>

    <div class="ibox-content">
        <?= Html::beginForm(Url::toRoute('/user-test/submit'), 'post', ['class' => 'form-group','id' => '_start']); ?>
            <?= Html::hiddenInput('ut_id', $userTestData->ut_id) ?>
            <table class="table table-bordered">
                <thead>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach (array_keys($userTestData->question_clones) as $idx => $qc_id) : ?>
                        <?php $qu = $userTestData->question_clones[$qc_id]; ?>
                        <tr>
                            <td>Question <?= $idx + 1 ?></td>
                            <td>
                                <div class="alert alert-info"><?= $qu['qc_content'] ?></div>
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
            <?=  Html::submitButton('Submit', ['class' => 'btn btn-primary', "onclick" => 'setFormSubmitting()'])  ?>
        
        <?php Html::endForm(); ?>
    </div>
</div>

<script>
var formSubmitting = false;
var setFormSubmitting = function() {
    formSubmitting = true;

};

$(function() {
    window.addEventListener("beforeunload", function (e) {
        if (formSubmitting) {
            return undefined;
        }

        var msg = "Do you really want to leave this page?";

        (e || window.event).returnValue = msg; //Gecko + IE
        return msg; //Gecko + Webkit, Safari, Chrome etc.
    });
    var duration= <?= $timeCount?>,
        display = document.querySelector('#countdown');
    startTimer(duration, display);   
});

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            $('#_start').submit();
        }
    }, 1000);
}


</script>
