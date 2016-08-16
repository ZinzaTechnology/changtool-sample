<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\TestExam */

$this->title = 'Create Test';
$this->params['breadcrumbs'][] = ['label' => 'Test Manager', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>

    <div class="ibox-content">
        <div class="test-exam-create">

            <?= $this->render('_create_form', [
                'model' => $testExam,
                'category' => $test_category,
                'level' => $test_level,
            ]) ?>

        </div>
    </div>
</div>
