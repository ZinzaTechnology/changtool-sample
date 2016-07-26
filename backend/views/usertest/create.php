<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$category = ['1' => 'PHP', '2' => 'C/C++', '3' => 'Java', '4' => 'SQL', '5' => 'C#'];
/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestions */

$this->title = 'Create Test Exam Questions';
$this->params['breadcrumbs'][] = ['label' => 'Test Exam Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-exam-questions-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(['options' => ['data' => ['pjax' => true]],]); ?>
    <?=
    $form->field($user, 'u_id')->dropDownList(
            ArrayHelper::map($user->find()->all(), 'u_id', 'u_name'), [
        'prompt' => 'Select User'
            ]
    )->label('User')
    ?>
    <!--- Cần chỉnh sửa lại link ----->
    <?= Html::a('Add new user', ['/user'], ['class' => 'btn btn-success']) ?>
    <?=
    $form->field($testExam, 'te_category')->dropdownList(
            $category, ['prompt' => '---Select Category---',
        'id' => 'category',
        'name' => 'category']
    )
    ?>
    <?=
    $form->field($testExam, 'te_level')->dropdownList(
            ['1' => 'Easy', '2' => 'Medium', '3' => 'Hard'], 
            ['prompt' => '---Select Level---',
            'id' => 'level',
            'name' => 'level']
    )
    ?>
    <div class="form-group">
        <?= Html::submitButton('Choose' ,['class' => 'btn btn-primary','name'=>'choose_category']) ?>
    </div>

    <?= Html::a('Add new test', ['/test'], ['class' => 'btn btn-success']) ?>
    <!-- -->
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
