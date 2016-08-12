<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Manager';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>

    <div class="ibox-content">
        <p><?= Html::a('Create Test Exam', ['create'], ['class' => 'btn btn-success'])?></p>
        <div class="hr-line-solid"></div>

        <?php ActiveForm::begin([
            'action' => Url::toRoute('/test-exam/index'),
            'method' => 'GET'
        ]); ?>
        <table class="table table-bordered">
            <tr>
                <th>Category</th>
                <td>
                    <?= Select2::widget([
                        'name' => 'te_category',
                        'data' => $category,
                        'value' => isset($te_search) ? $te_search['te_category'] : null,
                        'options' => [
                            'placeholder' => 'Select Category ...'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]); ?>
                </td>
                <th>Level</th>
                <td>
                    <?= Select2::widget([
                        'name' => 'te_level',
                        'data' => $level,
                        'value' => isset($te_search) ? $te_search['te_level'] : null,
                        'options' => [
                            'placeholder' => 'Select Level ...'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]); ?>
                </td>
            </tr>
                <td colspan="4">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
                </td>
            <tr>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>

        <div class="hr-line-solid"></div>

        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn'
                ],
                'te_code',
                [
                    'attribute' => 'te_category',
                    "content" => function ($model, $key, $index, $column) use ($category) {
                        return $category[$model->te_category];
                    }
                ],
                [
                    'attribute' => 'te_level',
                    "content" => function ($model, $key, $index, $column) use ($level) {
                        return $level[$model->te_level];
                    }
                ],
                'te_title',
                [
                    'attribute' => 'te_time',
                    "content" => function ($model, $key, $index, $column) use ($level) {
                        return $model->te_time.' mins';
                    }
                ],
                'te_num_of_questions',
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'class' => 'yii\grid\ActionColumn'
                ]
            ]
        ]);
        ?>
    </div>
</div>
