<?php
use yii\helpers\Html;
use yii\data\ActiveData\ActiveDataProvider;
/* @var $this yii\web\View */


$this->title = 'User';
?>
<div class="site-user">
	Time :30 min.<br>	
	Question number: 30.
		

<?php 
	foreach ($dataProvider as $data){
		echo $usertest->ut_id ."\t";
	}
	?>  

</div>
    