<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserTest */

$this->title = 'Doing Test';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-test-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::beginForm('','post',['class'=>'form-group']); ?>
	<?php 
		foreach($data as $d){
	?>
	<h3><?= $d['qc_content']?></h3>
	<?php 
		foreach($d['answer'] as $answer){?>
			<div><input type="radio" name="question-<?= $d['qc_id'] ?>" value="<?= $answer['ac_id']?>" /> <?= $answer['ac_content']?></div>
		<?php }
		
	}?>
	<?= Html::submitButton('Submit',['class'=>'btn btn-primary'])?>
	<?php Html::endForm(); ?>
</div>
