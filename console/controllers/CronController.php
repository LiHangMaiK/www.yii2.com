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

    /**
     * 计划任务可以写在这,利用crontab或者其他定时任务工具执行此方法
     * @param string $name
     * @return int
     */
    public function actionIndex($name='')
    {
        if($name){
            echo "hello {$name}";
        }else{
            echo "hello guest";
        }
        //返回的值为0，shell写法中exit(0)表示程序正常执行成功
        return self::EXIT_CODE_NORMAL;
        //返回code_error（1）表示执行失败
//        return self::EXIT_CODE_ERROR;
    }
}