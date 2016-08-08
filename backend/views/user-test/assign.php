<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

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
$this->title = 'Assign';
$this->params['breadcrumbs'][] = ['label' => 'User Test', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$class = __CLASS__;
if ($errors = Yii::$app->session->getFlash('assignErrors')) {
    foreach ($errors as $error) {
        ?>
        <div><?= $error ?></div>
        <?php
    }
}
?>
<div class="test-exam-questions-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $form = ActiveForm::begin([
                'action' => Url::toRoute(__FUNCTION__),
                'options' => ['data-pjax' => true],
                'enableClientValidation' => false,
                'enableAjaxValidation' => false,
    ]);
    ?>

    <h1>Test <?= Html::a('Add new test', Url::toRoute('test'), ['class' => 'btn btn-success']) ?></h1>
    <div class="col-md-6">
        <?=
        $form->field($testExam, 'te_category')->dropDownList(ArrayHelper::map($category, 'id', 'category'), [
            'onchange' => 'this.form.submit()',
            'prompt' => 'Select Category',
            'options' => [
                $choosen['te_category'] => ['Selected' => true],
            ],
        ])->label('Category')
        ?>
    </div>
    <div class="col-md-6">
        <?=
        $form->field($testExam, 'te_level')->dropDownList(ArrayHelper::map($level, 'id', 'level'), [
            'onchange' => 'this.form.submit()',
            'prompt' => 'Select Level',
            'options' => [
                $choosen['te_level'] => ['Selected' => true]
            ],
        ])->label('Level')
        ?>
    </div>
    <div>
        <?=
        maksyutin\duallistbox\Widget::widget([
            'model' => $testExam,
            'attribute' => 'te_id',
            'title' => 'List Test',
            'data' => $testList,
            'data_id' => 'te_id',
            'data_value' => 'te_title',
            'lngOptions' => [
                'search_placeholder' => 'Type whatever you want to search...',
                'available' => 'Test list',
                'selected' => 'Test selected',
            ]
        ]);
        ?>
    </div>

    <h1>User <?= Html::a('Add new user', Url::toRoute('site/index'), ['class' => 'btn btn-success']) ?></h1>

    <div>
        <?=
        maksyutin\duallistbox\Widget::widget([
            'model' => $user,
            'attribute' => 'u_id',
            'title' => 'User',
            'data' => $user->find(),
            'data_id' => 'u_id',
            'data_value' => 'u_name',
            'lngOptions' => [
                'search_placeholder' => 'Type whatever you want to search...',
                'available' => 'User list',
                'selected' => 'User selected',
            ]
        ]);
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Assign', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
