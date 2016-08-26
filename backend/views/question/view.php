<?php
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\grid\GridView;

$this->registerJsFile('/res/js/plugins/bootstrap-markdown/editormd.min.js');
$this->registerCssFile('/res/css/plugins/editormd.min.css');

$this->title = 'Question Manager';
$this->params['breadcrumbs'][] = [
    'label' => 'Question Manager',
    'url' => [
        'index'
    ]
];
($question) ? $this->params['breadcrumbs'][] = $question->q_id : null;
?>

<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget([ 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [ ] ])?>
    </div>
    <br>
    <div class="ibox-content">  
    
        <?php if ($question) : ?>
            <table class="table table-striped">
            <tr>
                <td colspan="2"><h4>Question content </h2><br>
                    <div id="editormd-view">
                        <textarea class="editormd-markdown-textarea" name="Question[q_content]"></textarea>
                        <textarea class="editormd-html-textarea" name="Question[q_content_html]"></textarea>
                    </div>
                </td>
                
                <script>
                $(function() {
                    var editor = editormd("editormd-view", {
                        width  : "100%",
                        readOnly: true,
                        markdown: <?= Json::htmlEncode($question['q_content'])?>,
                        path : "/res/lib/", // Autoload modules mode, codemirror, marked... dependents libs path
                    });
                });
                </script>
                
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

    </div>
    <br>
    <div class="ibox-content">
        <h3>Answer</h3>
        
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn'
                    ],
                    'qa_id',
                    'qa_content',
                    [
                        'attribute' => 'category',
                        "content" => function ($model, $key, $index, $column) use ($answer_status) {
                            return $answer_status[$model->qa_status];
                        }
                    ],
                    'created_at',
                    'updated_at',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{edit} {delete}',
                        'buttons' => [
                            
                            'edit' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                            },
                            
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'data-confirm' => 'Are you sure you want to delete this answer?',
                                    'data-method' => 'post'
                                ]);
                            }
                        ],
                        
                        'urlCreator' => function ($action, $dataProvider, $key, $index) {
                            
                            if ($action === 'edit') {
                                return Url::to([
                                    'question/edit-answer',
                                    'q_id' => $dataProvider['q_id'],
                                    'qa_id' => $dataProvider['qa_id']
                                ]);
                            }
                            if ($action === 'delete') {
                                return Url::to([
                                    'question/delete-answer',
                                    'q_id' => $dataProvider['q_id'],
                                    'qa_id' => $dataProvider['qa_id']
                                ]);
                            }
                            return $url;
                        }
                    ]
                ]
            ]);
            ?>  
        <?php else : ?>
            Question not found
        <?php endif; ?>
        </div>

    <br>
    <div class="ibox-content">
        <?= Html::a('Edit', ['/question/edit-question', 'q_id' => $question->q_id], ['class' => 'btn btn-success'])?>
        <?=Html::a('Delete', ['/question/delete','q_id' => $question->q_id ], ['class' => 'btn btn-danger','data' => ['confirm' => 'Are you sure you want to delete this item?','method' => 'post' ] ])?>
        <?= Html::a('Back', ['/question/index'], ['class' => 'btn btn-primary pull-right'])?>
    </div>
</div>
