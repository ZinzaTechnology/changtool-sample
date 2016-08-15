<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;

$this->title = "Question Manager";
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
        <div class="hr-line-solid"></div>

        <?= $this->render('test_search', ['level' => $level, 'category' => $category, 'type' => $type]); ?>

        <div class="hr-line-solid"></div>

        <?php ActiveForm::begin([
                'action' => Url::toRoute(['/test-exam/update','id' => $id]),
                'method' => 'post',
        ]); ?>
        <table class="table table-hover">
            <caption>QUESTION</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Level</th>
                    <th>Type</th>
                    <th>Content</th>
                    <th>Created date</th>
                    <th>Updated date</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($questions as $question) : ?>
                    <tr>
                        <td><?= '<input type="checkbox" name="option[]" value="'.$question->q_id.'" '.(in_array($question->q_id, $all_questions) ? 'checked disabled readonly' : '').' />'; ?></td>
                        <td><?= $category[$question->q_category] ?></td>
                        <td><?= $level[$question->q_level] ?></td>
                        <td><?= $type[$question->q_type] ?></td>
                        <td><?= $question->q_content ?></td>
                        <td><?= $question->created_at ?></td>
                        <td><?= $question->updated_at ?></td>
                        <td><?= Html::a('View', ['/question/view', 'q_id' => $question->q_id], ['class' => 'btn btn-warning']) ?></td>
                        <td><?= Html::a('Edit', ['/question/edit', 'q_id' => $question->q_id], ['class' => 'btn btn-warning']) ?></td>
                        <td><?= Html::a(
                            'Delete',
                            ['/question/delete', 'q_id' => $question->q_id],
                            ['class' => 'btn btn-danger', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]
                        ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= Html::submitButton('Add', ['name' => 'te_update', 'value' => 'add_question_complete', 'class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>