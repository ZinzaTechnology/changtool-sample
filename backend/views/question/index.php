<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\grid\GridView;

$this->title = "Question Manager";
$this->params ['breadcrumbs'] [] = $this->title;
?>

<div class="ibox">
	<div class="ibox-title">
		<h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget([ 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [ ] ])?>
    </div>
	<br>
	<div class="ibox-content">
        <?= Html::a('Create New Question', ['/question/insert-question'], ['class' => 'btn btn-primary']);?>
    </div>
	<div class="ibox-content">
        <?= $this->render('/question/_search', ['level' => $level, 'category' => $category, 'type' => $type,'selected' => $selected]); ?>
     </div>
	<br>
	<div class="ibox-content">
		<h3>Question</h3>
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn' 
                ],
                'q_content',
                [
                    'attribute' => 'q_category',
                    "content" => function ($model, $key, $index, $column) use ($category) {
                        return $category [$model->q_category];
                    } 
                ],
                [
                    'attribute' => 'q_category',
                    "content" => function ($model, $key, $index, $column) use ($level) {
                        return $level [$model->q_level];
                    } 
                ],
                [
                    'attribute' => 'q_category',
                    "content" => function ($model, $key, $index, $column) use ($type) {
                        return $type [$model->q_type];
                    } 
                ],
                'created_at',
                'updated_at',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {edit} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                        },
                        
                        'edit' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                        },
                        
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'data-confirm' => 'Are you sure you want to delete this item?',
                                'data-method' => 'post' 
                            ]);
                        } 
                    ],
                    
                    'urlCreator' => function ($action, $dataProvider, $key, $index) {
                        
                        if ($action === 'view') {
                            return Url::to([
                                'question/view',
                                'q_id' => $dataProvider ['q_id'] 
                            ]);
                        }
                        if ($action === 'edit') {
                            return Url::to([
                                'question/edit-question',
                                'q_id' => $dataProvider ['q_id'] 
                            ]);
                        }
                        if ($action === 'delete') {
                            return Url::to([
                                'question/delete',
                                'q_id' => $dataProvider ['q_id'] 
                            ]);
                        }
                        return $url;
                    } 
                ] 
            ] 
        ]);
        ?>  
    	</div>
</div>
