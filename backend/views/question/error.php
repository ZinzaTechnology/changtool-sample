<?php 
use yii\widgets\Breadcrumbs;
$this->title = "Error Manager";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ibox">
    <div class="ibox-title">
        <h1><?= $this->title ?></h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
    <div>
    <?php echo $error ; ?>
    </div>
</div>