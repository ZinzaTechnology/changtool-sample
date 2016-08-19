<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Import Data';
?>
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-2">
                <a href="<?= URL::toRoute("/import-data/question-answer") ?>"><button class="btn btn-primary dim m-btn-large-dim" type="button">
                    <i class="fa fa-users"></i>
                    <br><span class="m-btn-large-text">Account Manager</span>
                </button></a>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
    </div>
</div>
