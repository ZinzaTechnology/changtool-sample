<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\TestExamQuestionsSearch */
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
?>

<?php $form = Html::beginForm(); ?>
    Username <?= Html::input('text', 'u_name') ?>
    Category <?= Html::dropDownList('te_category', false, ArrayHelper::map($category, 'id', 'category')) ?>
    Level <?= Html::dropDownList('te_level', false, ArrayHelper::map($level, 'id', 'level')) ?>
    Title <?= Html::input('text', 'te_title') ?>
    Start date <?= Html::input('date', 'ut_start_at') ?>
    End date <?= Html::input('date', 'ut_finished_at') ?>
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
<?php Html::endForm(); ?>
