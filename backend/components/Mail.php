<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/6/20
 * Time: 0:18
 */

namespace backend\components;

use Yii;

class Mail
{
    /**
     * 发送邮件
     */
    public static function sendMail($event){
        //接收事件参数
        echo "email is {$event->email} <br>";
        echo "subject is {$event->subject} <br>";
        echo "content is {$event->content}";
    }
}