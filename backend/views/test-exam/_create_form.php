<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\controllers\GlobalVariableControllser;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-exam-form row">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-hovered">
        <tr>
            <td>
            <?= $form->field($model, 'te_category')->widget(Select2::classname(), [
                    'data' => $category,
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select Category ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
            ?>
            </td>
            <td>
            <?= $form->field($model, 'te_level')->widget(Select2::classname(), [
                    'data' => $level,
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select a Level ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
            ?>
            </td>
        </tr>
        <tr>
            <td>
            <?= $form->field($model, 'te_code')
                ->textInput()
                ->hint('Input the code of this exam');?>
            </td>
            <td>
            <?= $form->field($model, 'te_title')
                ->textInput()
                ->hint('Input the title of this exam');?>
            </td>
        </tr>
        <tr>
            <td>
            <?= $form->field($model, 'te_time')
                ->textInput(['type' => 'number'])
                ->hint('Input time to do this exam (in minutes)');?>
            </td>
            <td>
            <?= $form->field($model, 'te_num_of_questions')
                ->textInput(['type' => 'number'])
                ->hint('Input number question of this exam');?>
            </td>
        </tr>
        <tr>
            <td><?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?></td>
        </tr>

    </table>
    <?php ActiveForm::end(); ?>

</div>
