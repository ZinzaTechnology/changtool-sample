<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->ut_id;
$this->params['breadcrumbs'][] = ['label' => 'User Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-test-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ut_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ut_id], [
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
            'ut_id',
            'u_id',
            'te_id',
            'ut_status',
            'ut_mark',
            'ut_start_at',
            'ut_finished_at',
            'ut_question_clone_ids:ntext',
            'ut_user_answer_ids:ntext',
        ],
    ]) ?>

</div>
