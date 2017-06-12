<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/5/8
 * Time: 15:23
 */

namespace common\components;

class Helper
{
    public static function MyPrint($result)
    {
        echo '<pre>';print_r($result);exit();
    }

    public static function MyVarDump($result)
    {
        var_dump($result);exit();
    }
}