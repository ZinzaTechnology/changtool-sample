<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Doing Test';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-test-create" >
	

    <h1 style = 'color:#1a1aff'><?= Html::encode($this->title) ?></h1>
    <?= Html::beginForm('', 'post', ['class' => 'form-group','id'=>'_start']); ?>
    <h2 style = 'color:#e60000' >TIME LEFT:  <span id="countdown"> </span> </h2>
  	<div class="sk-spinner sk-spinner-three-bounce">
    <div class="sk-bounce1"></div>
    <div class="sk-bounce2"></div>
    <div class="sk-bounce3"></div>
    </div>
    <script>
    var formSubmitting = false;
    var setFormSubmitting = function() {
        formSubmitting = true;
        
       };

    window.onload = function() {
        window.addEventListener("beforeunload", function (e) {
            if (formSubmitting) {
                return undefined;
            }

            var msg = "Do you really want to leave this page?";

            (e || window.event).returnValue = msg; //Gecko + IE
            return msg; //Gecko + Webkit, Safari, Chrome etc.
        });
        var fiveMinutes = <?= $time_count ?>,
                display = document.querySelector('#countdown');
        startTimer(fiveMinutes, display);   
    };
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

       
    </script>
    <?php
    foreach ($data as $d) {
        ?>
        <h2 style = 'color:#52A2AB'><?= $d['qc_content']  ?> </h2>
        <?php foreach ($d['answer'] as $answer) { ?>
            <div style = 'color:#222E07'>
                <input type="checkbox" name="question-<?= $d['qc_id'] ?>[]" value="<?= $answer['ac_id'] ?>" /> 
                <?= $answer['ac_content'] ?>
            </div>
            <?php
        }
    }
    ?>
     <i class="fa fa-hand-o-right"></i>
    <?=  Html::submitButton('Submit', ['class' => 'btn btn-primary', "onclick" => 'setFormSubmitting()'])  ?>
    
    <?php Html::endForm(); ?>
</div>