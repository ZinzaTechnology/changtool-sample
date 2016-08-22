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
                            <div class="alert alert-info"><?= $qu['qc_content'] ?></div>
                            <?php if(isset($qu['answers'])): ?>
                                <?php if ($qu['qc_type'] == AppConstant::QUESTION_TYPE_SINGLE_ANSWER) : ?>
                                    <?php foreach ($qu['answers'] as $ans) : ?>
                                        <?=
                                        Html::radio("questions[$qc_id][]", false, [
                                            'class' => 'i-checks',
                                            'checked' => isset($userAnswer[$qc_id][$ans['ac_id']])? true : false,
                                            'disabled' => true])
                                        ?>
                                        <?= Html::label($ans['ac_content'], "q_{$qc_id}_{$ans['ac_id']}") ?><br>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?php foreach ($qu['answers'] as $ans) : ?>
                                        <?=
                                        Html::checkbox("questions[$qc_id][]", false, [
                                            'class' => 'i-checks',
                                            'checked' => isset($userAnswer[$qc_id][$ans['ac_id']])? true : false,
                                            'disabled' => true])
                                        ?>
                                <?= Html::label($ans['ac_content'], "q_{$qc_id}_{$ans['ac_id']}") ?><br>
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
