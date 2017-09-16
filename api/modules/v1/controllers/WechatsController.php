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

        //使用redis缓存
        $cache = yii::$app->cache;

        //获取
        $accessToken = $cache->getOrSet('wechat.AccessToken', function () {
            //需要的参数
            $appId      = yii::$app->params['wechat.appId'];
            $appSecret  = yii::$app->params['wechat.appSecret'];
            $url        = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";

            //获取AccessToken
            $output = yii::$app->helper->getCurlOutput($url);

            //处理成数组
            $result = json_decode($output,true);

            //返回AccessToken
            return $result['access_token'];
        },7200);

        
    }

}
