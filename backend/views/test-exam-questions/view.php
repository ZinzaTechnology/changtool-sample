<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */

$this->title = $model->te_id;
$this->params['breadcrumbs'][] = ['label' => 'Test Exam Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-questions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'te_id' => $model->te_id, 'q_id' => $model->q_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'te_id' => $model->te_id, 'q_id' => $model->q_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'te.te_title',
            'q.q_content',
            'not_use:boolean',
        ],
    ]) ?>

</div>
