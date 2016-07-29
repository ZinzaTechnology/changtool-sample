<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <?php if ($user_test_models) : ?>
        <?php foreach ($user_test_models as $data) : ?>
            <div style='width:250px;float:left'>
                <div style='width:90%;height:140px;border: 4px solid #163'> Test Ability </div>
                <div style='margin:0 auto 0;'>
                    <?php
                    switch ($data['ut_status']) {
                        case "DONE":
                            echo Html::a("DONE at {$data['ut_finished_at']}", ['/user-test/result', 'id' => $data['ut_id']], ['class' => 'btn btn-success']);
                            break;
                        case "DOING":
                            echo Html::a("DOING (started at {$data['ut_start_at']})", Url::toRoute(['user-test/do', 'id' => $data['ut_id']]), ['class' => 'btn btn-success']);
                            break;
                        case "ASSIGNED":
                            echo Html::a('Start', Url::toRoute(['user-test/start-test', 'id' => $data['ut_id']]), ['class' => 'btn btn-success']);
                            break;
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
