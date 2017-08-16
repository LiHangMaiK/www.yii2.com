<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/8/16
 * Time: 23:51
 */

namespace api\components;

class response
{
    /**
     * 回复文本消息
     */
    public static function echoText($event)
    {
        //回复消息
        $info = sprintf($event->getTemplate(),$event->toUserName,$event->fromUserName,$event->createTime,$event->getMsgType(),$event->content);
        echo $info;exit;
    }

}