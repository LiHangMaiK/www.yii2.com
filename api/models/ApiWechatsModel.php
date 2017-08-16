<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/8/16
 * Time: 0:32
 */
namespace api\models;

use yii;
use common\models\WechatsModel;

class ApiWechatsModel extends WechatsModel
{
    /**
     * 判断请求是否来自微信
     */
    public function valid()
    {
        //1.获取get参数
        $nonce      = yii::$app->request->get('nonce');     //随机字符串
        $timestamp  = yii::$app->request->get('timestamp'); //时间戳
        $signature  = yii::$app->request->get('signature'); //服务端加密后的字符串,用来比对
        $echoStr    = yii::$app->request->get('echostr');   //验证通过后需要输出的字符串

        //2.验证传入参数
        if($this->checkSignature($timestamp,$nonce,$signature)){
            echo $echoStr ? $echoStr : '';//是否第一次验证
            return TRUE;
        }
        exit();//验证失败，直接退出。
    }

    /**
     * 处理接收到的消息
     */
    public function reponseMsg()
    {
        //1.获取到微信推送过来的POST数据(xml格式),注意不是普通POST数据，而是元数据,要用$GLOBALS['HTTP_RAW_POST_DATA']接收。
        //yii2默认POST是要经过CSRF验证的，这里微信不会带CSRF的cookie，所以要先禁用CSRF。
        $postArr = yii::$app->request->getRawBody();
        $postObj = simplexml_load_string($postArr);
        //2.处理消息类型，并设置回复类型和内容
        switch (strtolower($postObj->MsgType)){
            case 'event':
                $this->reponseForEvent($postObj);//事件消息
                break;
            case 'text':
                $this->reponseForText($postObj);//文本消息
                break;
//            case 'image':
//                $this->reponseForImage($postObj);//图片消息
//                break;
//            case 'voice':
//                $this->reponseForVoice($postObj);//语音消息
//                break;
//            case 'video':
//                $this->reponseForVideo($postObj);//视频消息
//                break;
//            case 'shortvideo':
//                $this->reponseForShortVideo($postObj);//小视频消息
//                break;
//            case 'location':
//                $this->reponseForLocation($postObj);//地理位置消息
//                break;
//            case 'link':
//                $this->reponseForLink($postObj);//链接消息
//                break;
        }
    }

    /**
     * 关注/取消关注事件
     */
    private function reponseForEvent($postObj)
    {
        switch (strtolower($postObj->Event)){
            case 'subscribe':
                $this->subscribe($postObj);//订阅事件
                break;
            case 'unsubscribe':
                $this->unSubscribe($postObj);//取消订阅事件
                break;
            case 'LOCATION':
                $this->location($postObj);//上报地理位置事件
                break;
        }
    }

    /**
     * 订阅事件
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[FromUser]]></FromUserName>
     * <CreateTime>123456789</CreateTime>
     * <MsgType><![CDATA[event]]></MsgType>
     * <Event><![CDATA[subscribe]]></Event>
     * </xml>
     */
    private function subscribe($postObj)
    {
        //回复消息
        $toUser     = $postObj->FromUserName;
        $fromUser   = $postObj->ToUserName;
        $createTime = time();
        $msgType    = 'text';
        $content    = '欢迎关注我的微信公众帐号,嘻嘻！';

        $template   = '<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        </xml>';
        $info       = sprintf($template,$toUser,$fromUser,$createTime,$msgType.$content);
        echo $info;exit;
    }

    /**
     * 取消订阅事件
     */
    private function unSubscribe()
    {
        throw new NotSupportedException('"reponseForText" is not implemented.');
    }

    /**
     * 上报地理位置事件
     */
    private function location()
    {
        throw new NotSupportedException('"reponseForText" is not implemented.');
    }

    /**
     * 文本消息
     */
    private function reponseForText()
    {
        throw new NotSupportedException('"reponseForText" is not implemented.');
    }


    /**
     * 验证参数是否一致
     *
     * @param $timestamp
     * @param $nonce
     * @param $signature
     * @return bool
     */
    private function checkSignature($timestamp,$nonce,$signature)
    {

        $token  = yii::$app->params['wechat']['token']; //微信服务端和本地都商量好的token

        //2.将timestamo,nonce,token按字典序排序,再把三个参数拼接,用sha1加密
        $array  = [$token,$nonce,$timestamp];//存放在数组里方便处理
        sort($array);                       //字典排序
        $tmpStr = implode('',$array);       //拼接字符串
        $tmpStr = sha1($tmpStr);            //sha1加密

        //3.将加密后的字符串与signature进行对比,判断该请求是否来自微信
        return $tmpStr === $signature ? TRUE : FALSE;
    }
}
