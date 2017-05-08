<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/5/8
 * Time: 15:23
 */

namespace common\components\helper;

class MyHelper
{
    public static function MyPrint($result)
    {
        echo '<pre>';print_r($result);exit();
    }

    public static function MyVardump($result)
    {
        var_dump($result);exit();
    }
}