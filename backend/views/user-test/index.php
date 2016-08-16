<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'User Test';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
<div class="ibox">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
    <?= Html::beginForm(Url::toRoute(__METHOD__), 'POST', ['class' => 'form']); ?>
    <div class="row m-b-md">
        <div class="col-md-3">
            <div class="ibox-content">
                <div class="form-group">
                    <label>Username</label>
                    <?= Html::input('text', 'u_name', $selected['u_name'], ['class' => 'form-control', 'placeholder' => 'Username...']) ?>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <?= Html::input('text', 'te_title', $selected['te_title'], ['class' => 'form-control', 'placeholder' => 'Title...']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox-content">
                <div class="form-group">
                    <label>Category</label>
                    <?= Html::dropDownList('te_category', $selected['te_category'], $category, [ 'prompt' => 'Select Category...', 'class' => 'form-control m-b']) ?>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <?= Html::dropDownList('te_level', $selected['te_level'], $level, ['prompt' => 'Select Level...', 'class' => 'form-control m-b']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ibox-content">
                <div class="form-group">
                    <label>Start date</label>
                    <?= Html::input('date', 'ut_start_at', $selected['ut_start_at'], ['class' => 'form-control']) ?>
                </div>
                <div class="form-group">
                    <label>End date</label> <?= Html::input('date', 'ut_finished_at', $selected['ut_finished_at'], ['class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="ibox-title">
                <h5>Form actions</h5>
            </div>
            <div class="ibox-content text-center">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'name' => 'submit', 'value' => 'search']) ?>
                <?= Html::submitButton('Reset', ['class' => 'btn btn-white', 'name' => 'submit', 'value' => 'reset']) ?>
            </div>
            <div class="text-center m-t-md">
                <?= Html::a('Assign test to User', ['assign'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php Html::endForm() ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Username',
                'value' => function ($model) {
                    return $model['u_name'];
                },
            ],
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
                'value' => function ($model) {
                    return $model['ut_status'];
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
        <?php Pjax::end(); ?>