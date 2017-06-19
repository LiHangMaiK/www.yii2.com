<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/6/20
 * Time: 0:49
 */

namespace backend\components\event;

use yii\base\Event;

class MailEvent extends Event
{
    public $email;

    public $subject;

    public $content;
}