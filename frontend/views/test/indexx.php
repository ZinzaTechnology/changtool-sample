<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;



/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Exams';
?>

<div class="test-exam-index">
	
    <h1><?= Html::encode($this->title) ?></h1>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'te_id',
            //'te_code',
            //'te_category',
            //'te_level',
            //'te_title',
            // 'te_time:datetime',
            // 'te_num_of_questions',
            // 'te_created_at',
            // 'te_last_updated_at',
            // 'te_is_deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'test_exam')->textArea() ?>
	<?php ActiveForm::end(); ?>
    
</div>
