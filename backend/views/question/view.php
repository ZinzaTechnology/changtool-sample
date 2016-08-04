<?php 
use yii\helpers\Html;
?>		

<?php if($question): ?>
    <table class="table table-hover">
        <tr><td>Question content</td><td><?= $question->q_content ?></td></tr>
        <tr><td>Category</td><td><?= $category[$question->q_category]?></td></tr>
        <tr><td>Type</td><td><?= $type[$question->q_type] ?></td></tr>
        <tr><td>Created date</td><td><?= $question->created_at ?></td></tr>
        <tr><td>Updated date</td><td><?= $question->updated_at ?></td></tr>
    </table>

    <div class="hr-line-solid"></div>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <caption>TABLE ANSWER</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Content Answer</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>    
                    <?php foreach ($answers as $answer): ?>
                    <tr>
                        <td><?= $answer->qa_id ?></td>
                        <td><?= $answer->qa_content ?></td>
                        <td><?= $answer_status[$answer->qa_status] ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="hr-line-solid"></div>

    <?= Html::a('Edit', ['/question/edit', 'q_id' => $question->q_id], ['class' => 'btn btn-warning'])?>
    <?= Html::a('Delete', ['/question/delete', 'q_id' => $question->q_id], 
        ['class' => 'btn btn-danger','data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post']
        ]) ?>

<?php else: ?>
    <h3>Question not found</h3>
<?php endif; ?>

<?= Html::a('Back', ['/question/index'], ['class' => 'btn btn-success pull-right']) ?>
