<?php

namespace api\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ApiAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //全局CSS
    public $css = [
        'css/site.css',
    ];
    //全局JS
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    /**********下面两个方法，是自动加载CSS,JS文件的方法****************/
    /* 视图中：\backend\assets\ApiAsset::addCss($this,'@web/css/main.css');***********/

    //定义按需加载JS方法，注意加载顺序在最后
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [ApiAsset::className(), "depends" => "api\assets\ApiAsset"]);
    }
    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [ApiAsset::className(), "depends" => "api\assets\ApiAsset"]);
    }
}
