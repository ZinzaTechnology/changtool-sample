<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */

$this->title = $model->te_id;
$this->params['breadcrumbs'][] = ['label' => 'Test Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->te_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->te_id], [
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
            'te_id',
            'te_code',
            'te_category',
            'te_level',
            'te_title',
            'te_time:datetime',
            'te_num_of_questions',
            'te_created_at',
            'te_last_updated_at',
            'te_is_deleted',
        ],
    ]) ?>

</div>
