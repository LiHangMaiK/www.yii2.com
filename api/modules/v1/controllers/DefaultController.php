<?php

namespace api\modules\v1\controllers;

use yii\web\Controller;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends Controller
{
    /**
     * 微信验证token
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //1.将timestamo,nonce,token按字典序排序
        //2.将排序后的三个参数拼接之后用sha1加密
        //3.将加密后的字符串与signature进行对比,判断该请求是否来自微信
        echo 1;exit();
    }

    /**
     * 错误方法
     */
    public function actionError()
    {

    }
}
