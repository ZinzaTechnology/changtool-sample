<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Admin Dashboard';
?>
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-2">
                <a href="<?= URL::toRoute("/user") ?>"><button class="btn btn-primary dim m-btn-large-dim" type="button">
                        <i class="fa fa-users"></i>
                        <br><span class="m-btn-large-text">Account Manager</span>
                </button></a>
            </div>
        </div>

        <div class="hr-line-dashed"></div>

        <div class="row">
            <div class="col-lg-2">
                <a href="<?= URL::toRoute("/question") ?>"><button class="btn btn-primary dim m-btn-large-dim" type="button">
                        <i class="fa fa-question-circle"></i>
                        <br><span class="m-btn-large-text">Question Manager</span>
                </button></a>
            </div>

            <div class="col-lg-2">
                <a href="<?= URL::toRoute("/test-exam") ?>"><button class="btn btn-primary dim m-btn-large-dim" type="button">
                        <i class="fa fa-book"></i>
                        <br><span class="m-btn-large-text">Test Manager</span>
                </button></a>
            </div>
            <div class="col-lg-2">
                <a href="<?= URL::toRoute("/user-test") ?>"><button class="btn btn-primary dim m-btn-large-dim" type="button">
                        <i class="fa fa-tasks"></i>
                        <br><span class="m-btn-large-text">User Test Manager</span>
                </button></a>
            </div>
        </div>

        <div class="hr-line-dashed"></div>

        <div class="row">
            <div class="col-lg-2">
                <a href="<?= URL::toRoute("/import-data") ?>"><button class="btn btn-primary dim m-btn-large-dim" type="button">
                    <i class="fa fa-upload"></i>
                    <br><span class="m-btn-large-text">Import Data</span>
                </button></a>
            </div>
        </div>
    </div>
</div>
