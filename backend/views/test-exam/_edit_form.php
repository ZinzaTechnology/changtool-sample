<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>

<div class="test-exam-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <!-- Test information udpate area -->
    <div class="test_exam">
        <div class="info">
            <b>TestExam Information.</b>
        </div>

        <div class="row">
            <div class="col-md-9">
                <table class="table table-bordered">
                    <tr>
                        <td>
                        <?= $form->field($testExam, 'te_category')->widget(Select2::classname(), [
                                'data' => $testCategory,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select Category ...'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]);
                        ?>
                        </td>
                        <td>
                        <?= $form->field($testExam, 'te_level')->widget(Select2::classname(), [
                                'data' => $testLevel,
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
                        <?= $form->field($testExam, 'te_code')
                            ->textInput()
                            ->hint('Input the code of this exam');?>
                        </td>
                        <td>
                        <?= $form->field($testExam, 'te_title')
                            ->textInput()
                            ->hint('Input the title of this exam');?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <?= $form->field($testExam, 'te_time')
                            ->textInput(['type' => 'number'])
                            ->hint('Input time to do this exam (in minutes)');?>
                        </td>
                        <td>
                        <?= $form->field($testExam, 'te_num_of_questions')
                            ->textInput(['type' => 'number'])
                            ->hint('Input number question of this exam');?>
                        </td>
                    </tr>
                </table>
                <div class="hr-line-solid"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?= Html::a('Add Question', ['create'], ['class' => 'btn btn-success']) ?>
                <div class="hr-line-dashed"></div>
            </div>

            <div class="col-md-9">
                <?php
                    $q_count = 1;
                    foreach($questions as $q) {
                        echo '<div class="row">';
                        echo '<div class="col-md-9">';
                        echo $form->field($q, 'q_content')->textArea(['style'=>'height: 100px', 'class' => 'col-md-9'])
                            ->label("Question $q_count", ['class' => 'col-md-3']);
                        echo '</div>';

                        echo '<div class="col-md-3" style="padding-top: 20px">';
                        echo Html::a("Delete Question $q_count", ['deleteq','te_id' => $testExam->te_id, 'q_id' => $q['q_id']], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                ],
                        ]);
                        echo '</div>';
                        echo '</div>';
                        
                        ++$q_count;
                    }
                ?>
           </div> 
        </div>

        <div class="hr-line-solid"></div>
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div>
