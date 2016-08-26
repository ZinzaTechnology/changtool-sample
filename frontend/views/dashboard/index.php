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
            $stClass = "";
            $started = false;
            switch ($data['ut_status']) {
                case "DONE":
                    $link = Url::toRoute(['/user-test/result', 'id' => $data['ut_id']]);
                    $stClass = "badge-plain";
                    $started = true;
                    break;
                case "DOING":
                    $link = Url::toRoute(['user-test/do', 'id' => $data['ut_id']]);
                    $stClass = "badge-danger";
                    $started = true;
                    break;
                case "ASSIGNED":
                    $link = Url::toRoute(['user-test/start-test', 'id' => $data['ut_id']]);
                    $stClass = "badge-primary";
                    break;
            }
            ?>
            <div class='col-md-3'>
                <a href='<?= $link ?>'>
                    <div class="widget lazur-bg p-lg text-center">
                        <div class="m-b-md">
                            
                            <h1 class="m-xs"><?= $data['te_title'] ?></h1>
                            
                            <?= $category[$data['te_category']] ?><br>
                            Question: <?=  $data['te_num_of_questions'] ?>
                            <h3><span class="badge <?= $stClass ?>"><?= $data['ut_status'] ?></span></h3>

                            <?php if ($data['ut_status'] == "DONE") : ?>
                                <h1><i class="fa fa-eye"></i> View Result</h1>
                                <small>Score: <?= $data['ut_mark'] ?></small>
                            <?php elseif ($data['ut_status'] == "DOING") : ?>
                                <h1><i class="fa fa-play"></i> Continue</h1>
                                <small>Start at: <?= $data['ut_start_at'] ?></small>
                            <?php elseif ($data['ut_status'] == "ASSIGNED") : ?>
                                <h1><i class="fa fa-play-circle-o"></i> Start</h1>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>    
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
