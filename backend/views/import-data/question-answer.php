<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = 'Import Question - Answer';
$this->params['breadcrumbs'][] = ['label' => 'Import Data', 'url' => Url::toRoute('/import-data')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
</div>
