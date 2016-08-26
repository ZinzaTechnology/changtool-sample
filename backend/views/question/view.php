<?php
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\grid\GridView;
use common\lib\components\AppConstant;

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
    
    <?php if (!$question) : ?>
        <div class="ibox-content">  
            Question not found
        </div>
    <?php else : ?>
        <div class="ibox-content">  
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
                        'attribute' => 'status',
                        "content" => function ($model, $key, $index, $column) use ($answer_status) {
                            if ($model->qa_status == AppConstant::ANSWER_STATUS_RIGHT) {
                                $statusContent = "<span class='label label-primary'>True</span>";
                            } else {
                                $statusContent = "<span class='label label-danger'>Wrong</span>";
                            }
                            return $statusContent;
                        }
                    ],
                    'created_at',
                    'updated_at',
                ]
            ]);
            ?>  
        </div>

        <br>
        <div class="ibox-content">
            <?= Html::a('Edit', ['/question/edit-question', 'q_id' => $question->q_id], ['class' => 'btn btn-success'])?>
            <?=Html::a('Delete', ['/question/delete','q_id' => $question->q_id ], ['class' => 'btn btn-danger','data' => ['confirm' => 'Are you sure you want to delete this item?','method' => 'post' ] ])?>
            <?= Html::a('Back', ['/question/index'], ['class' => 'btn btn-primary pull-right'])?>
        </div>
    <?php endif; ?>
</div>
