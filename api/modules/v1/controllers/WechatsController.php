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
     * 微信消息入口
     */
    public function actionWechatAccess()
    {
        //创建模型
        $Wechats = new ApiWechatsModel();

        //1.验证微信请求
        $Wechats->valid();
        
        //2.处理接收到的微信请求
        $Wechats->responseMsg();
    }

    public function actionGetAccessToken(){
        $appId      = yii::$app->params['wechat.appId'];
        $appSecret  = yii::$app->params['wechat.appSecret'];

        $url        = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
        $output = yii::$app->helper->getCurlOutput($url);

        $result = json_decode($output,true);

        $cache = yii::$app->cache;

        

    }

}
