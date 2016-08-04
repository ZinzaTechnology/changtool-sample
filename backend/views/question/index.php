<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>

<p><?= Html::a('Create New Question', ['/question/create'], ['class' => 'btn btn-success']);?></p>
<div class="hr-line-solid"></div>

<?= $this->render('/question/_search', ['level' => $level, 'category' => $category, 'type' => $type]); ?>

<div class="hr-line-solid"></div>
<table class="table table-hover">
    <caption>QUESTION</caption>
    <thead>
        <tr>
            <th>ID</th>
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
    <?php foreach ($questions as $question): ?>
        <tr>
            <td><?= $question->q_id ?></td>
            <td><?= $category[$question->q_category] ?></td>
            <td><?= $level[$question->q_level] ?></td>
            <td><?= $type[$question->q_type] ?></td>
            <td><?= $question->q_content ?></td>
            <td><?= $question->created_at ?></td>
            <td><?= $question->updated_at ?></td>
            <td><?= Html::a('View', ['/question/view', 'q_id' => $question->q_id], ['class' => 'btn btn-warning']) ?></td>
            <td><?= Html::a('Edit', ['/question/edit', 'q_id' => $question->q_id], ['class' => 'btn btn-warning']) ?></td>
            <td><?= Html::a('Delete', 
                ['/question/delete', 'q_id' => $question->q_id], 
                ['class' => 'btn btn-danger', 'data' => 
                    ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]
                ) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

