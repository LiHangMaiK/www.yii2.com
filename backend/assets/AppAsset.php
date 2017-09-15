<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //全局CSS
    public $css = [
        'static/css/site.css',
    ];
    //全局JS
    public $js = [
        'http://cdn.staticfile.org/jquery.qrcode/1.0/jquery.qrcode.min.js',
    ];
    //依赖文件，先引入下面这些文件再引入全局文件
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
    /**********下面两个方法，是自动加载CSS,JS文件的方法****************/
    /* 视图中：\backend\assets\AppAsset::addCss($this,'@web/css/main.css');***********/
    //上面填写全局的CSS,JS。按需加载的JS，CSS就在视图中直接引入，不需要在此文件中引入

    //定义按需加载JS方法，注意加载顺序在最后
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [AppAsset::className(), "depends" => "backend\assets\AppAsset"]);
    }
    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [AppAsset::className(), "depends" => "backend\assets\AppAsset"]);
    }
}
