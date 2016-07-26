<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Doing Test';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-test-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::beginForm('', 'post', ['class' => 'form-group','id'=>'_start']); ?>
    <h3>TIME LEFT: <span id="countdown"></span></h3>
    <script>
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10)
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    $('#_start').submit();
                }
            }, 1000);
        }

        window.onload = function () {
            var fiveMinutes = <?= $time_count ?>,
                    display = document.querySelector('#countdown');
            startTimer(fiveMinutes, display);
        };
    </script>
    <?php
    foreach ($data as $d) {
        ?>
        <h3><?= $d['qc_content'] ?></h3>
        <?php foreach ($d['answer'] as $answer) { ?>
            <div>
                <input type="checkbox" name="question-<?= $d['qc_id'] ?>[]" value="<?= $answer['ac_id'] ?>" /> 
                <?= $answer['ac_content'] ?>
            </div>
            <?php
        }
    }
    ?>
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    <?php Html::endForm(); ?>
</div>