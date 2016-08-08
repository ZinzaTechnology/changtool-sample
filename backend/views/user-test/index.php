<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestExamQuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$category = [
    ['id' => '1', 'category' => 'PHP'],
    ['id' => '2', 'category' => 'C/C++'],
    ['id' => '3', 'category' => 'Java'],
    ['id' => '4', 'category' => 'SQL'],
    ['id' => '5', 'category' => 'C#']
];
$level = [
    ['id' => '1', 'level' => 'Easy'],
    [ 'id' => '2', 'level' => 'Normal'],
    ['id' => '3', 'level' => 'Hard']
];
$this->title = 'Test Exam Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-questions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::beginForm(Url::toRoute(__METHOD__), 'POST', ['class' => 'form-group']); ?>
    Username <?= Html::input('text', 'u_name', $selected['u_name']) ?>
    Category <?= Html::dropDownList('te_category', $selected['te_category'], ArrayHelper::map($category, 'id', 'category'), ['prompt' => 'Select User',]) ?>
    Level <?= Html::dropDownList('te_level', $selected['te_level'], ArrayHelper::map($level, 'id', 'level'), ['prompt' => 'Select User',]) ?>
    Title <?= Html::input('text', 'te_title', $selected['te_title']) ?>
    Start date <?= Html::input('date', 'ut_start_at') ?>
    End date <?= Html::input('date', 'ut_finished_at') ?>
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?php Html::endForm() ?>

    <p>
        <?= Html::a('Create Test Exam Questions', ['assign'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Username',
                'value' => function($model) {
                    return $model['u_name'];
                },
            ],
            [
                'attribute' => 'Category',
                'value' => function($model) use ($category) {
                    return $category[$model['te_category'] - 1]['category'];
                },
            ],
            [
                'attribute' => 'Title',
                'value' => function($model) {
                    return $model['te_title'];
                },
            ],
            [
                'attribute' => 'Status',
                'value' => function($model) {
                    return $model['ut_status'];
                },
            ],
            [
                'attribute' => 'Start Time',
                'value' => function($model) {
                    return $model['ut_start_at'];
                },
            ],
            [
                'attribute' => 'End Time',
                'value' => function($model) {
                    return $model['ut_finished_at'];
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['detail', 'id' => $model['ut_id']]));
                    },
                            'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete', 'id' => $model['ut_id']]));
                    }
                        ],
                    ],
                ],
            ]);
            ?>
</div>
