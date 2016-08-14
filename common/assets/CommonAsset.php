<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CommonAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '/';
    public $css = [
        'res/css/bootstrap.min.css',
        'res/css/animate.css',
        'res/css/style.css',
        'res/css/page.css',
        'res/font-awesome/css/font-awesome.css',
    ];
    public $js = [
        "res/js/bootstrap.min.js",
        "res/js/plugins/metisMenu/jquery.metisMenu.js",
        "res/js/plugins/slimscroll/jquery.slimscroll.min.js",
        "res/js/inspinia.js",
        "res/js/plugins/pace/pace.min.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
