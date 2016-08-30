<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
    </div>
    <br>
    <div class="ibox-content">
        <?= GridView::widget([
            'dataProvider' => $userTestDataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'Category',
                    'value' => function ($model) use ($category) {
                        return $category[$model['te_category']];
                    },
                ],
                [
                    'attribute' => 'Title',
                    'value' => function ($model) {
                        return $model['te_title'];
                    },
                ],
                [
                    'attribute' => 'Status',
                    'content' => function ($model, $key, $index, $column) {
                        $stClass = "";
                        switch ($model['ut_status']) {
                            case "DONE":
                                $stClass = "badge-plain";
                                break;
                            case "DOING":
                                $stClass = "badge-danger";
                                break;
                            case "ASSIGNED":
                                $stClass = "badge-primary";
                                break;
                        }
                        return "<span class='badge $stClass'>{$model['ut_status']}</span>";
                    },
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{action}',
                    'buttons' => [
                        'action' => function ($url, $model) {
                            $link = [];
                            $text = "";
                            $icon = "";
                            switch ($model['ut_status']) {
                                case "DONE":
                                    $link = Url::toRoute(['/user-test/result', 'id' => $model['ut_id']]);
                                    $text = "Results";
                                    $icon = "fa-eye";
                                    break;
                                case "DOING":
                                    $link = Url::toRoute(['user-test/do', 'id' => $model['ut_id']]);
                                    $text = "Continue";
                                    $icon = "fa-play";
                                    break;
                                case "ASSIGNED":
                                    $link = Url::toRoute(['user-test/start-test', 'id' => $model['ut_id']]);
                                    $text = "Start";
                                    $icon = "fa-play-circle-o";
                                    break;
                            }
                            return Html::a("<i class='fa $icon'></i> $text", $link);
                        },
                    ],
                ],
                [
                    'attribute' => 'Mark',
                    'value' => function ($model) {
                        return $model['ut_mark'];
                    },
                ],
                [
                    'attribute' => 'Start Time',
                    'value' => function ($model) {
                        return $model['ut_start_at'];
                    },
                ],
                [
                    'attribute' => 'End Time',
                    'value' => function ($model) {
                        return $model['ut_finished_at'];
                    },
                ],
            ],
        ]); ?>
    </div>
</div>
