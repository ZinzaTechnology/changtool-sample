<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use common\models\UserSearch;
use common\models\User;
use yii\data\Pagination;

$this->title = 'Accounts';

?>

<div class="ibox">
    <div class="user-index">    
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a('New Account', ['create'], ['class' => 'btn btn-success']) ?>
            <?= $this->render('_search', ['model' => $searchModel]) ?>
        </p>
        
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
                'u_role',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>  
    </div>
</div>
