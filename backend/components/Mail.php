<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/6/20
 * Time: 0:18
 *
 * 邮件类，通过事件来发送邮件
 * 需要控制器下init方法绑定此类 $this->on(self::SEND_MAIL,['backend\components\Mail','sendMail']);
 * 方法中 $this->trigger(SELF::SEND_MAIL,$event); 来触发
 *
 */

namespace backend\components;

use Yii;

class Mail
{
    /**
     * 发送邮件
     */
    public static function sendMail($event){

        $mail= Yii::$app->mailer->compose();
        $mail->setTo($event->email); //要发送给那个人的邮箱
        $mail->setSubject($event->subject); //邮件主题
        $mail->setTextBody($event->content); //发布纯文字文本
//        $mail->setHtmlBody("<br>问我我我我我");    //发布可以带html标签的文本

        return $mail->send();
    }
}