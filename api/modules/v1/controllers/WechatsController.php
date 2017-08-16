<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/8/15
 * Time: 11:23
 */

namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use api\models\ApiWechatsModel;

/**
 * Wechat controller for the `v1` module
 */
class WechatsController extends ActiveController
{

    public $modelClass = '';

    /**
     * 微信入口
     */
    public function actionWechatAccess()
    {
        $Wechats = new ApiWechatsModel();
        //1.验证微信请求
        $Wechats->valid();

        //2.处理接收到的微信请求
        $Wechats->reponseMsg();

    }



}
