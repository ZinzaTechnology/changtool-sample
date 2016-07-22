<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\UserTest */

$this->title = 'Create User Test';
$this->params['breadcrumbs'][] = ['label' => 'User Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
