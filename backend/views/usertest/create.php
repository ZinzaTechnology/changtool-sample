<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$category = [
    ['id' => '1', 'category' => 'PHP'],
    ['id' => '2', 'category' => 'C/C++'],
    ['id' => '3', 'category' => 'Java'],
    ['id' => '4', 'category' => 'SQL'],
    ['id' => '5', 'category' => 'C#']
];
$level = [
    ['id' => '1', 'level' => 'Easy'],
    [ 'id' => '2', 'level' => 'Normal'],
    ['id' => '3', 'level' => 'Hard']
];
var_dump($request = Yii::$app->request->post());
$this->title = 'Create Test Exam Questions';
$this->params['breadcrumbs'][] = ['label' => 'Test Exam Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-questions-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'method' => 'post'
        ]); ?>

    <?=
    $form->field($user, 'u_id')->dropDownList(ArrayHelper::map($user->find()->all(), 'u_id', 'u_name'), [
        'prompt' => 'Select User',
        'options' => [
            $extInfo['User']['u_id'] => ['Selected' => true],
        ],
    ])->label('User')
    ?>

    <?= Html::a('Add new user', Url::toRoute('site/index'), ['class' => 'btn btn-success']) ?>

    <?=
    $form->field($testExam, 'te_category')->dropDownList(ArrayHelper::map($category, 'id', 'category'), [
        'prompt' => 'Select Category',
        'options' => [
            $extInfo['TestExam']['te_category'] => ['Selected' => true]
        ]
    ])->label('Category')
    ?>

    <?=
    $form->field($testExam, 'te_level')->dropDownList(ArrayHelper::map($level, 'id', 'level'), [
        'prompt' => 'Select Level',
        'options' => [
            $extInfo['TestExam']['te_level'] => ['Selected' => true]
        ]
    ])->label('Level')
    ?>

    <div class="form-group">
        <?= Html::submitButton('Get list Test', ['class' => 'btn btn-primary', 'name' => 'submit', 'value' => 'choose']) ?>
    </div>

    <?php
    if ($listTest)
        echo $form->field($testExam, 'te_id')->dropDownList(ArrayHelper::map($listTest, 'te_id', 'te_title'), [
            'prompt' => 'Select Test',
            'options' => [
                'te_id' => ['Selected' => true]
            ]
        ])->label('All Test you can choose')
        ?>

    <?= Html::a('Add new test', Url::toRoute('test'), ['class' => 'btn btn-success']) ?>

    <h1>Information</h1>

    User        <?= empty($choosen['User']) ? '' : $choosen['User']['u_name'] ?><br />
    <?php
    if (!empty($choosen['TestExam'])) {
        ?>
        Title       <?= empty($choosen['TestExam']) ? '' : $choosen['TestExam']['te_title'] ?><br />
        Time        <?= empty($choosen['TestExam']) ? '' : $choosen['TestExam']['te_time'] . " minutes" ?><br />
        Questions   <?= empty($choosen['TestExam']) ? '' : $choosen['TestExam']['te_num_of_questions'] ?><br />
    <?php } ?>
    Category    <?= isset($extInfo) ? $category[$extInfo['TestExam']['te_category'] - 1]['category'] : '' ?><br />
    Level       <?= isset($extInfo) ? $level[$extInfo['TestExam']['te_level'] - 1]['level'] : '' ?><br />
    <div class="form-group">
        <?= Html::submitButton('Assign', ['class' => 'btn btn-primary', 'name' => 'submit', 'value' => 'assign']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
