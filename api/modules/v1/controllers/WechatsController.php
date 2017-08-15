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
     * 微信入口
     */
    public function actionWechatAccess(){

        //1.验证微信请求
        $this->valid();

        //2.处理接收到的微信请求
        $this->reponseMsg();

    }

    /**
     * 处理接收到的消息
     */
    private function reponseMsg(){
        
    }

    /**
     * 判断请求是否来自微信
     */
    private function valid()
    {
        //1.将timestamo,nonce,token按字典序排序
        $nonce      = yii::$app->request->get('nonce');     //随机字符串
        $timestamp  = yii::$app->request->get('timestamp'); //时间戳
        $signature  = yii::$app->request->get('signature'); //服务端加密后的字符串,用来比对
        $echoStr    = yii::$app->request->get('echostr');   //验证通过后需要输出的字符串

        //验证传入参数
        if($this->checkSignature($timestamp,$nonce,$signature)){
            echo $echoStr ? $echoStr : '';//是否第一次
            return TRUE;
        }
        exit();
    }

    /**
     * 验证参数是否一致
     *
     * @param $timestamp
     * @param $nonce
     * @param $signature
     * @return bool
     */
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
