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

/**
 * Wechat controller for the `v1` module
 */
class WechatsController extends ActiveController
{
    public $modelClass = '';

    /**
     * 微信验证方法
     */
    public function actionValid()
    {
        //1.将timestamo,nonce,token按字典序排序
        $nonce      = yii::$app->request->get('nonce');     //随机字符串
        $timestamp  = yii::$app->request->get('timestamp'); //时间戳
        $signature  = yii::$app->request->get('signature'); //服务端加密后的字符串,用来比对
        $echoStr    = yii::$app->request->get('echostr');   //验证通过后需要输出的字符串

        //验证请求是否来自微信
        if($this->checkSignature($timestamp,$nonce,$signature)){
            echo $echoStr;
        }

        exit();
    }

    private function checkSignature($timestamp,$nonce,$signature){

        $token      = yii::$app->params['wechat']['token']; //微信服务端和本地都商量好的token

        //2.将排序后的三个参数拼接之后用sha1加密
        $array  = [$token,$nonce,$timestamp];//存放在数组里方便处理
        sort($array);                       //字典排序
        $tmpStr = implode('',$array);       //拼接字符串
        $tmpStr = sha1($tmpStr);            //sha1加密

        //3.将加密后的字符串与signature进行对比,判断该请求是否来自微信
        return $tmpStr === $signature ? TRUE : FALSE;
    }
}
