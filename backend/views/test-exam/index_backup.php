<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\controllers\GlobalVariableControllser;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\bootstrap\Button;
use yii\grid\CheckboxColumn;

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Exams';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
?>
<div class="test-exam-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table width="800">
        <tr>
            <td width="200">
                <p>
                <?= Html::a('Create Test Exam', ['create'], ['class' => 'btn btn-success'])?>
                </p>
            </td>

<?php
$form = ActiveForm::begin([ 
    'action' => Url::toRoute('test-exam/searchtestexam/'),
    'method' => 'GET' 
]);
echo "<td width='200'>";
echo "<b>Category</b><br \>";
echo Select2::widget([
    'name' => 'te_category',
    'data' => ArrayHelper::map($category, 'id', 'name'),
    'value' => $session['te_category'],
    'options' => [ 
        'placeholder' => 'Select Category ...' 
    ],
    'pluginOptions' => [ 
        'allowClear' => true 
    ] 
]);
echo "</td>";

echo "<td width='200'>";
echo "<b>Level</b><br \>";
echo Select2::widget([ 
    'name' => 'te_level',
    'data' => ArrayHelper::map($level, 'id', 'name'),
    'value' => $session['te_level'],
    'options' => [ 
        'placeholder' => 'Select Level ...' 
    ],
    'pluginOptions' => [ 
        'allowClear' => true 
    ] 
] );
echo "</td>";
echo "<td width='200' align='right'>";
echo Html::submitButton('Search', [ 
    'class' => 'btn btn-success' 
]);
echo "</td>";
ActiveForm::end();
?>
            </tr>
        </table>


<?php
if ($session['is_assign_test_exam'] == "no") {
    echo GridView::widget( [ 
        'dataProvider' => $dataProvider,
        'columns' => [ 
            [ 
                'class' => 'yii\grid\SerialColumn' 
            ],
            'te_code',
            [ 
                'attribute' => 'te_category',
                "content" => function($model, $key, $index, $column) use ($category) {
                    return $category[$model->te_category];
                } 
            ],
            [ 
                'attribute' => 'te_level',
                "content" => function($model, $key, $index, $column) use ($level) {
                    return $level[$model->te_level];
                } 
            ],
            'te_title',
            'te_time:datetime',
            'te_num_of_questions',
            'created_at',
            'updated_at',
            [ 
                'class' => 'yii\grid\ActionColumn' 
            ] 
        ] 
] );
} else {
    $form = ActiveForm::begin([ 
        'action' => Url::toRoute('test-exam/assigntestexam/'),
        'method' => 'GET' 
    ] );

    echo GridView::widget([ 
        'dataProvider' => $dataProvider,
        'columns' => [ 
            [ 
                'class' => 'yii\grid\SerialColumn' 
            ],
            [ 
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function($dataProvider, $key, $index, $column) {
                    return [ 
                        "value" => $dataProvider->te_id,
                    ];
                } 
        ],
        'te_code',
        [ 
            'attribute' => 'te_category',
            "content" => function($model, $key, $index, $column) use ($category) {
                return $category[$model->te_category];
            } 

        ],
        [ 
            'attribute' => 'te_level',
            "content" => function($model, $key, $index, $column) use ($level) {
                return $level[$model->te_level];
            } 
    ],
        'te_title',
        'te_time:datetime',
        'te_num_of_questions',
        'created_at',
        'updated_at',
        [ 
            'class' => yii\grid\ActionColumn::className(),
            'template' => '{view} {update}' 
        ] 
    ] 
] );

    echo Html::submitButton('Assign TestExam', [ 
        'class' => 'btn btn-success' 
    ]);

    ActiveForm::end();
}
?>
</div>
