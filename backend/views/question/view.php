<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Question Manager';
$this->params ['breadcrumbs'] [] = [
    'label' => 'Question Manager',
    'url' => [
        'index' 
    ] 
];
($question) ? $this->params ['breadcrumbs'] [] = $question->q_id : null;
?>

<div class="ibox">
	<div class="ibox-title">
		<h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ] ] )?>
    </div>

	<div class="ibox-content">
		<div class="hr-line-solid"></div>

        <?php if($question): ?>
            <table class="table table-hover">
			<tr>
				<td>Question content</td>
				<td><?= $question->q_content ?></td>
			</tr>
			<tr>
				<td>Category</td>
				<td><?= $category[$question->q_category]?></td>
			</tr>
			<tr>
				<td>Type</td>
				<td><?= $type[$question->q_type] ?></td>
			</tr>
			<tr>
				<td>Created date</td>
				<td><?= $question->created_at ?></td>
			</tr>
			<tr>
				<td>Updated date</td>
				<td><?= $question->updated_at ?></td>
			</tr>
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
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>    
                            <?php foreach ($answers as $answer): ?>
                            <tr>
							<td><?= $answer->qa_id ?></td>
							<td><?= $answer->qa_content ?></td>
							<td><?= $answer_status[$answer->qa_status] ?></td>
							<td> <?= Html::a('Edit', ['/question/edit-answer','qa_id' => $answer->qa_id,'q_id' => $question->q_id], ['class' => 'btn btn-success'])?></td>
							<td> <?=Html::a ( 'Delete', [ '/question/delete-answer','qa_id' => $answer->qa_id,'q_id' => $question->q_id ], [ 'class' => 'btn btn-danger','data' => [ 'confirm' => 'Are you sure you want to delete this item?','method' => 'post' ] ] )?>
					              </td>
						</tr>
                            <?php endforeach ?>
                        </tbody>
				</table>
			</div>
		</div>
		<div class="hr-line-solid"></div>

            <?= Html::a('Edit', ['/question/edit', 'q_id' => $question->q_id], ['class' => 'btn btn-success'])?>
            <?=Html::a ( 'Delete', [ '/question/delete','q_id' => $question->q_id ], [ 'class' => 'btn btn-danger','data' => [ 'confirm' => 'Are you sure you want to delete this item?','method' => 'post' ] ] )?>

        <?php else: ?>
            Question not found
             
        <?php endif; ?>

       		<?= Html::a('Back', ['/question/index'], ['class' => 'btn btn-primary pull-right'])?>
    </div>
</div>
