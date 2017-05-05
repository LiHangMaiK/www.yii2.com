<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/5/1
 * Time: 3:03
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
        echo strtotime('2017-05-04 07:06:00');
    }
}