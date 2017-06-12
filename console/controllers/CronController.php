<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/5/18
 * Time: 2:48
 */

namespace console\controllers;

use yii\console\Controller;

class CronController extends Controller
{

    public function actionIndex($name)
    {
        echo "hello {$name}";

        return self::EXIT_CODE_NORMAL;
    }
}