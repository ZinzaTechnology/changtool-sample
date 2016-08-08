<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
use backend\widgets\SideMenu;
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
                            <li><a href="<?= Url::toRoute("/user/logout") ?>">Logout</a></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="logo-element">
                        <a href="<?=Url::toRoute("/")?>">CHang</a>
                    </div>
                </li>
                <?php if (!$current_user): ?>
                <li class="active">
                    <a href="<?= Url::toRoute("/user/login")?>"><i class="fa fa-sign-in"></i> <span class="nav-label">Login</span></a>
                </li>
                <?php else:
                echo SideMenu::widget([
                    'options' => [
                        'tag' => null,
                    ],
                    'customTemplateOptions' => ['icon'],
                    'items' => [
                        [
                            'label' => 'Dashboard',
                            'icon' => 'fa-delicious',
                            'url' => ["/dashboard"]
                        ],
                        [
                            'label' => 'Account Manager',
                            'icon' => 'fa-users',
                            'url' => ["/account-manager"]
                        ],
                        [
                            'label' => 'Question Manager',
                            'icon' => 'fa-question-circle',
                            'url' => ["/question"]
                        ],
                        [
                            'label' => 'Test Manager',
                            'icon' => 'fa-book',
                            'url' => ["/test-exam"]
                        ],
                        [
                            'label' => 'User Test Manager',
                            'icon' => 'fa-tasks',
                            'url' => ["/user-test"]
                        ],
                    ],
                ]);
                endif; ?>
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="<?=Url::toRoute("/")?>"><span class="m-r-sm text-muted welcome-message">ZINZA CHangTool Backend</span></a></li>
                    </ul>
                </div>
                <?php if ($current_user): ?>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="<?= Url::toRoute("/user/logout") ?>">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>
                <?php endif;?>
            </nav>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
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
