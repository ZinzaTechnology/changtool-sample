<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use common\models\UserSearch;
use common\models\User;
use yii\data\Pagination;
use yii\widgets\Breadcrumbs;

$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ibox">
	<div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?=Breadcrumbs::widget([ 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [ ] ])?>
    </div>
    <br>
    <div class="ibox-content"> 
            <?= Html::a('New Account', ['create'], ['class' => 'btn btn-success']) ?>
            <?= $this->render('_search', ['model' => $searchModel]) ?>
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
                ['class' => yii\grid\ActionColumn::className(), 'template' => '{update}']
            ],
        ]); ?>  
     </div>
</div>
