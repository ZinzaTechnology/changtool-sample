<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;

$this->title = 'Import Question - Answer';
$this->params['breadcrumbs'][] = ['label' => 'Import Data', 'url' => Url::toRoute('/import-data')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ibox">
    <div class="ibox-title">
        <h1><?= Html::encode($this->title) ?></h1>
        <?=
        Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])
        ?>
    </div>
    <div class="ibox-content">
        <div class="small">
            
        </div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($model, 'excelFile')->fileInput() ?>
        <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
