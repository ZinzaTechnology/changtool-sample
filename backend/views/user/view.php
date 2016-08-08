<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Test */

$this->title = $model->u_name;
//$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
<div class ="row">
	<div class="lg-col-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'u_id',
            'u_name',
    		'u_fullname',
            'u_mail',
            //'u_phone',
            //'u_password_hash',
            //'u_password_reset_token',
            //'u_auth_key',
            'u_role',
            //'u_created_at',
            //'u_updated_at',
            //'u_is_deleted',
        ],
    ]) ?>

	<p>
        <?= Html::a('Update', ['update', 'id' => $model->u_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->u_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Cancel', ['/user/index'], ['class'=>'btn btn-primary grid-button']) ?>
    </p>
    </div>
</div>	
</div>
