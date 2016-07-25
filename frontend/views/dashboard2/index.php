<?php
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */


$this->title = 'Test Ability';
?>

	<h1>Test Assigned</h1>
  <?php 
  
  //var_dump($user_test_models);
  //echo "<br \>-----------------<br \>";
  //var_dump($test_exams);
	foreach ($user_test_models as $data){
		?>
		
		<div style='width:250px;float:left'>
		<div style='width:90%;height:140px;border: 4px solid #000'><?=$data->ut_status?> </div>
		<div style='margin:0 auto 0;'>
		<?php
			switch($data->ut_status){
				case "DONE":
					echo Html::a('DONE',['#'],['class'=>'btn btn-success']);
					break;
				case "DOING":
					echo Html::a('DOING',['#'],['class'=>'btn btn-success']);
					break;
				case "ASSIGNED":
					echo Html::a('Start',Url::toRoute(['/user-test/start','ut_id' => $data->ut_id]),['class'=>'btn btn-success']);
					break;
			}
		?>
		</div>
		</div>
	<?php }?>


