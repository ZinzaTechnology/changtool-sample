<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use common\models\UserSearch;
use common\models\User;

$this->title = 'Accounts';

?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('New Account', ['create'], ['class' => 'btn btn-success']) ?>
        <?= $this->render('_search', ['model' => $searchModel]) ?>
    </p>
    <?php
        /*foreach ($dataProvider as $data)
        {
            echo $data->u_name ."\t";
		}*/
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $key, $index, $grid) {
        
                return ['id' => $model['u_id'], 'style' => "cursor: pointer", 'onclick' => 'location.href="'
                . Yii::$app->urlManager->createUrl('user/view')
                .'?id="+(this.id);',];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'u_id',
            'u_name',
            'u_mail',
            'u_fullname',
            //'u_phone',
            //'u_password_hash',
            // 'u_password_reset_token',
            // 'u_auth_key',
            'u_role',
            // 'u_created_at',
            // 'u_updated_at',
            // 'u_is_deleted',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
</div>
