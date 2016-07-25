<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Exams';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Test Exam', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'te_id',
            'te_code',
            'te_category',
            'te_level',
            'te_title',
            // 'te_time:datetime',
            // 'te_num_of_questions',
            // 'te_created_at',
            // 'te_last_updated_at',
            // 'te_is_deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
