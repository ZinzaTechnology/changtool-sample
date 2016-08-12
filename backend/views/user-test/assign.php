<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Assign Test';
$this->params['breadcrumbs'][] = ['label' => 'Assign test to user', 'url' => ['index']];
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="row">
    <?php
    $form = ActiveForm::begin([
                'action' => Url::toRoute(__FUNCTION__),
                'options' => ['data-pjax' => true],
                'enableClientValidation' => false,
                'enableAjaxValidation' => false,
    ]);
    ?>
    <div class="col-md-6">
        <div class="ibox-title">
            <h3>Test</h3>
            <?= Html::a('Add new user', Url::toRoute('site/index'), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="ibox-content">
            <div class="col-md-6">
                <?=
                $form->field($testExam, 'te_category')->dropDownList($category, [
                    'onchange' => 'this.form.submit()',
                    'prompt' => 'Select Category',
                    'options' => [
                        $category_choice => ['Selected' => true],
                    ],
                ])->label('Category')
                ?>
            </div>
            <div class="col-md-6">
                <?=
                $form->field($testExam, 'te_level')->dropDownList($level, [
                    'onchange' => 'this.form.submit()',
                    'prompt' => 'Select Level',
                    'options' => [
                        $level_choice => ['Selected' => true]
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
                        'search_placeholder' => 'Search...',
                        'available' => 'Test list',
                        'selected' => 'Test selected',
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="ibox-title">
            <h3>User</h3>
            <?= Html::a('Add new user', Url::toRoute('site/index'), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="ibox-content">
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
                        'search_placeholder' => 'Search...',
                        'available' => 'User list',
                        'selected' => 'User selected',
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="m-t-xs text-center ibox-content">
            <?= Html::submitButton('Assign Test', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="m-t-md"> </div>
