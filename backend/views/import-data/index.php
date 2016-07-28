<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = 'Import Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-2">
                <a href="<?= URL::toRoute("/import-data/question-answer") ?>"><button class="btn btn-primary dim m-btn-large-dim" type="button">
                    <i class="fa fa-file-excel-o"></i>
                    <br><span class="m-btn-large-text">Question - Answer</span>
                </button></a>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
    </div>
</div>
