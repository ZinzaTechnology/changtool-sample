<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use common\widgets\Alert;
use common\assets\CommonAsset;

AppAsset::register($this);
CommonAsset::register($this);
$current_user = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <?php if ($current_user): ?>
                    <div class="dropdown profile-element">
                        <img alt="user image" class="image-circle" src="<?= $current_user->getAvatar()?>" />
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= $current_user->u_name?></strong>
                         </span> <span class="text-muted text-xs block"> <?= $current_user->u_role ?><b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="<?= URL::toRoute("/user/logout") ?>">Logout</a></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="logo-element">
                        <a href="<?=URL::toRoute("/")?>">CHang</a>
                    </div>
                </li>
                <?php if (!$current_user): ?>
                <li class="active">
                    <a href="<?= URL::toRoute("/user/login")?>"><i class="fa fa-sign-in"></i> <span class="nav-label">Login</span></a>
                </li>
                <?php else: ?>
                <li class="active">
                    <a href="<?= URL::toRoute("/account-manager")?>"><i class="fa fa-users"></i> <span class="nav-label">Account Manager</span></a>
                </li>
                <li>
                    <a href="<?= URL::toRoute("/question")?>"><i class="fa fa-question-circle"></i> <span class="nav-label">Question Manager</span></a>
                </li>
                <li>
                    <a href="<?= URL::toRoute("/test-manager")?>"><i class="fa fa-book"></i> <span class="nav-label">Test Manager</span></a>
                </li>
                <li>
                    <a href="<?= URL::toRoute("/usertest-manager")?>"><i class="fa fa-tasks"></i> <span class="nav-label">User Test Manager</span></a>
                </li>
                <?php endif; ?>
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="<?=URL::toRoute("/")?>"><span class="m-r-sm text-muted welcome-message">ZINZA CHangTool Backend</span></a></li>
                    </ul>
                </div>
                <?php if ($current_user): ?>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="<?= URL::toRoute("/user/logout") ?>">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>
                <?php endif;?>
            </nav>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>

        <footer class="footer">
            <div class="footer">
                <p class="pull-left">&copy; ZINZA Technology<?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
