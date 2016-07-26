<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestExamQuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$category = ['1' => 'PHP', '2' => 'C/C++', '3' => 'Java', '4' => 'SQL', '5' => 'C#'];
$level = ['1' => 'Easy', '2' => 'Normal', '3' => 'Hard'];
$this->title = 'Test Exam Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-questions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search'); ?>
    <p>
        <?= Html::a('Create Test Exam Questions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'Username',
            [
                'attribute' => 'Category',
                'value' => function($model) use ($category) {
                    return $category[$model['Category']];
                },
            ],
            'Title',
            [
                'attribute' => 'Level',
                'value' => function($model) use ($level) {
                    return $level[$model['Level']];
                },
            ],
            'Status',
            'Start time',
            'End time',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', "view?id={$model['Id']}");
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', "delete?id={$model['Id']}");
                    }
                ],
            ],
        ],
    ]);
    ?>
</div>
