<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/6/20
 * Time: 0:23
 *
 * 发送邮件的测试控制器，其他控制器遵循此方法，就可以方便的发邮件
 * 用事件来发送邮件
 *
 */

namespace backend\controllers;

use yii\web\Controller;
use backend\components\event\MailEvent;

class SendMailController extends Controller
{
    const SEND_MAIL = 'send_mail';

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        //绑定邮件类，当事件触发的时候，调用我们刚刚定义的邮件类Mail
        $this->on(self::SEND_MAIL,['backend\components\Mail','sendMail']);
    }


    /**
     * 触发邮件事件
     */
    public function actionSend(){

        //发送邮件需要传递一些参数，创建Event子类，然后新建属性。
        $event = new MailEvent();
        $event->email   = 'l541425845@gmail.com';
        $event->subject = '来自yii2的一封邮件';
        $event->content = '这是一封测试邮件，test,test!';

        //触发
        $this->trigger(SELF::SEND_MAIL,$event);

    }
}