<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <?php if ($user_test_models) : ?>
        <?php foreach ($user_test_models as $count => $data) : ?>
        	<?php 
        	$link = [];
        	switch ($data['ut_status']) {
        		case "DONE":
        			$link = Url::toRoute(['/user-test/result', 'id' => $data['ut_id']]);
        			break;
        		case "DOING":
        			$link = Url::toRoute(['user-test/do', 'id' => $data['ut_id']]);
        			break;
        		case "ASSIGNED":
        			$link = Url::toRoute(['user-test/start-test', 'id' => $data['ut_id']]);
        			break;
        	}
        	?>
        	<div class='col-md-4'>
        	<a href='<?= $link ?>'>
       		<div class="widget yellow-bg p-lg text-center">
            	<div class="m-b-md">
                	
                            <h1 class="m-xs">Test Ability</h1>
                            
                            <?= $category[$te_infor[$count]['te_category']] ?> <br>	
                            Question: <?=  $data['te_num_of_questions'] ?> <br>
                            <h3 class="font-bold no-margins">
                                <?= $data['ut_status'] ?>
                            </h3>
                            <small><?= $data['ut_start_at'] ?></small>
                        </div>
                    </div>
                    </a>	
                    </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
