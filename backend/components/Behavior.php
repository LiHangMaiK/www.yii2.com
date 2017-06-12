<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/5/6
 * Time: 4:54
 */

namespace backend\components;

use Yii;
use yii\base\ActionFilter;

class Behavior extends ActionFilter
{
    //这只是一个简单的例子，会在访问后台所有Action之前调用此方法
    public function beforeAction ($action)
    {
        return true;
    }

    //自定义判断是否为访客的方法
    public function isGuest ()
    {
        return Yii::$app->user->isGuest;
    }
}