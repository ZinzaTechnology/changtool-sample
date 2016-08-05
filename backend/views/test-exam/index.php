<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\controllers\GlobalVariableControllser;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\bootstrap\Button;
use yii\grid\CheckboxColumn;

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$session = Yii::$app->session;
if (! $session->isActive) {
	$session->open ();
}

$this->title = 'Test Exams';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="test-exam-index">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<table width="800">
		<tr>
			<td width="200">
				<p>
        		<?= Html::a('Create Test Exam', ['create'], ['class' => 'btn btn-success'])?>
    		</p>
			</td>
    <?php
				$form = ActiveForm::begin ( [ 
						'action' => Url::toRoute ( 'test-exam/searchtestexam/' ),
						'method' => 'GET' 
				] );
				// // Use DropDown List
				// echo $form->field($model, 'te_category')->dropDownList(
				// $model->find()->select(['te_category', 'te_id'])->indexBy('te_id')->column(),
				// ['prompt'=>'Select category']);
				
				// echo $form->field($model, 'te_level')->dropDownList(
				// ArrayHelper::map($model->find()->all(),'te_id','te_level'),
				// ['prompt'=>'Select Level']);
				
				// Auto Suggest DropDown Search
				// echo "<td width='200'>";
				// echo $form->field($model, 'te_category')->widget(Select2::classname(), [
				// //'data' => ArrayHelper::map($model->find()->all(),'te_category',$category['name']),
				// 'data' => ArrayHelper::map($category,'id','name'),
				// 'options' => ['placeholder' => 'Select a state ...'],
				// 'pluginOptions' => [
				// 'allowClear' => true
				// ],
				// ]);
				// echo "</td>";
				// echo "<td width='200'>";
				// echo $form->field($model, 'te_level')->widget(Select2::classname(), [
				// //'data' => ArrayHelper::map($model->find()->all(),'te_level','te_level'),
				// 'data' => ArrayHelper::map($level,'id','name'),
				// 'options' => ['placeholder' => 'Select a state ...'],
				// 'pluginOptions' => [
				// 'allowClear' => true
				// ],
				// ]);
				// echo "</td>";
				echo "<td width='200'>";
				echo "<b>Category</b><br \>";
				echo Select2::widget ( [
						// 'data' => ArrayHelper::map($model->find()->all(),'te_category',$category['name']),
						'name' => 'te_category',
						'data' => ArrayHelper::map ( $category, 'id', 'name' ),
						'value' => $session ['te_category'],
						'options' => [ 
								'placeholder' => 'Select Category ...' 
						],
						'pluginOptions' => [ 
								'allowClear' => true 
						] 
				] );
				echo "</td>";
				
				echo "<td width='200'>";
				echo "<b>Level</b><br \>";
				echo Select2::widget ( [ 
						'name' => 'te_level',
						'data' => ArrayHelper::map ( $level, 'id', 'name' ),
						'value' => $session ['te_level'],
						'options' => [ 
								'placeholder' => 'Select Level ...' 
						],
						'pluginOptions' => [ 
								'allowClear' => true 
						] 
				] );
				echo "</td>";
				echo "<td width='200' align='right'>";
				echo Html::submitButton ( 'Search', [ 
						'class' => 'btn btn-success' 
				] );
				echo "</td>";
				// Ha.nk start
				// allow multiple items to be checked:
				// echo $form->field($model, 'items[]')->checkboxList(['a' => 'Item A', 'b' => 'Item B', 'c' => 'Item C']);
				
				// echo $form->field($model,'te_category')->dropDownList(
				// ArrayHelper::map($category,'id','name'),
				// [
				// 'prompt' => 'Select Category'
				// ]
				// );
				// echo $form->field($model,'te_level')->dropDownList(
				// ArrayHelper::map($level,'id','name'),
				// [
				// 'prompt' => 'Select Level',
				// 'options' => [
				
				// ]
				// ]
				// );
				// echo "<div class='form-group'>";
				// echo Html::submitButton('Search', ['class' => 'btn btn-success' ]);
				// echo "</div>";
				// Ha.nk end
				ActiveForm::end ();
				?>
</tr>
	</table>
    	
    	
    <?php //Pjax::begin(); ?>
    <?php
				if ($session ['is_assign_test_exam'] == "no") {
					echo GridView::widget ( [ 
							'dataProvider' => $dataProvider,
							// 'filterModel' => $searchModel,
							'columns' => [ 
									[ 
											'class' => 'yii\grid\SerialColumn' 
									],
									'te_code',
									[ 
											'attribute' => 'te_category',
											// 'label' => Yii::t('id', 'name'),
											"content" => function ($model, $key, $index, $column) use ($category) {
												return $category [array_search ( $model->te_category, array_column ( $category, 'id' ) )] ['name'];
											} 
									],
									[ 
											'attribute' => 'te_level',
											// 'label' => Yii::t('id', 'name'),
											"content" => function ($model, $key, $index, $column) use ($level) {
												return $level [array_search ( $model->te_level, array_column ( $level, 'id' ) )] ['name'];
											} 
									],
									'te_title',
									'te_time:datetime',
									'te_num_of_questions',
									'te_created_at',
									'te_last_updated_at',
									[ 
											'class' => 'yii\grid\ActionColumn' 
									] 
							] 
					] );
				} else {
					$form = ActiveForm::begin ( [ 
							'action' => Url::toRoute ( 'test-exam/assigntestexam/' ),
							'method' => 'GET' 
					] );
					
					echo GridView::widget ( [ 
							'dataProvider' => $dataProvider,
							// 'filterModel' => $searchModel,
							'columns' => [ 
									[ 
											'class' => 'yii\grid\SerialColumn' 
									],
									[ 
											'class' => 'yii\grid\CheckboxColumn',
											// 'name' => 'Select',
											'checkboxOptions' => function ($dataProvider, $key, $index, $column) {
												return [ 
														"value" => $dataProvider->te_id,
												];
											} 
									],
									'te_code',
									[ 
											'attribute' => 'te_category',
											// 'label' => Yii::t('id', 'name'),
											"content" => function ($model, $key, $index, $column) use ($category) {
												return $category [array_search ( $model->te_category, array_column ( $category, 'id' ) )] ['name'];
											} 
											
									],
									[ 
											'attribute' => 'te_level',
											// 'label' => Yii::t('id', 'name'),
											"content" => function ($model, $key, $index, $column) use ($level) {
												return $level [array_search ( $model->te_level, array_column ( $level, 'id' ) )] ['name'];
											} 
									],
									'te_title',
									'te_time:datetime',
									'te_num_of_questions',
									'te_created_at',
									'te_last_updated_at',
									// ['class' => 'yii\grid\ActionColumn',
									// [
									// 'update' => 'false',
									// ],
									// ],
									[ 
											'class' => yii\grid\ActionColumn::className (),
											'template' => '{view} {update}' 
									] 
							] 
					] );
					
					echo Html::submitButton ( 'Asign TestExam', [ 
							'class' => 'btn btn-success' 
					] );
					
					ActiveForm::end ();
				}
				?>
</div>
