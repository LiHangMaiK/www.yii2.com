<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/8/16
 * Time: 0:32
 */
namespace api\models;

use yii;
use common\models\WechatReplyModel;
use common\models\WechatsModel;
use api\components\event\TextEvent;

class ApiWechatsModel extends WechatsModel
{
    const ECHO_TEXT         = 'echo_text';//设置返回文本事件

    /**
     * 初始化模型
     */
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->on(self::ECHO_TEXT,['api\components\Response','echoText']);//设置回复事件
    }

    /**
     * 获取微信accessToken
     * @return string
     */
    public function getWechatAccessToken(){

            //使用redis
            $cache = yii::$app->cache;

            //从redis缓存中去取值
            $AccessToken = $cache->getOrSet('wechat.AccessToken', function () {
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

        return $AccessToken;
    }

    /**
     * 获取微信服务器IP地址
     */
    public static function getWechatServerIp(){
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=';
    }

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
        
        if(!$nonce || !$timestamp || !$signature){
            file_put_contents('request_error.txt', $nonce.PHP_EOL.$timestamp.PHP_EOL.$signature);
            echo 'success';exit();
        }
        
        //2.验证传入参数
        if($this->checkSignature($timestamp,$nonce,$signature)){
            echo $echoStr ? $echoStr : '';//是否第一次验证
            return TRUE;
        }
        throw new \yii\web\ForbiddenHttpException;//验证失败
    }

    /**
     * 处理接收到的消息
     */
    public function responseMsg()
    {
        //1.获取到微信推送过来的POST数据(xml格式),注意不是普通POST数据，而是元数据,要用$GLOBALS['HTTP_RAW_POST_DATA']接收。
        //yii2默认POST是要经过CSRF验证的，这里微信不会带CSRF的cookie，所以要先禁用CSRF。
        $postArr = yii::$app->request->getRawBody();

        //解析xml成xml对象
        $xmlObj = simplexml_load_string($postArr, 'SimpleXMLElement', LIBXML_NOCDATA);

        //转换成普通对象
        $postObj = json_decode(json_encode($xmlObj));

        //2.处理消息类型，并设置回复类型和内容
        switch (strtolower($postObj->MsgType)){
            case 'event':
                $this->responseForEvent($postObj);//事件消息
                break;
            case 'text':
                $this->responseForText($postObj);//文本消息
                break;
//            case 'image':
//                $this->responseForImage($postObj);//图片消息
//                break;
//            case 'voice':
//                $this->responseForVoice($postObj);//语音消息
//                break;
//            case 'video':
//                $this->responseForVideo($postObj);//视频消息
//                break;
//            case 'shortvideo':
//                $this->responseForShortVideo($postObj);//小视频消息
//                break;
//            case 'location':
//                $this->responseForLocation($postObj);//地理位置消息
//                break;
//            case 'link':
//                $this->responseForLink($postObj);//链接消息
//                break;
        }
    }

    /**
     * 订阅/取消订阅事件
     * 判断具体事件来进行操作
     */
    private function responseForEvent($postObj)
    {
        switch (strtolower($postObj->Event)){
            case 'subscribe':
                $this->subscribe($postObj);//订阅事件
                break;
            case 'unsubscribe':
                $this->unSubscribe($postObj);//取消订阅事件
                break;
//            case 'LOCATION':
//                $this->location($postObj);//上报地理位置事件
//                break;
        }
    }

    /**
     * 文本消息
     * <xml>
     *  <ToUserName><![CDATA[gh_9318200e22c4]]></ToUserName>
     *  <FromUserName><![CDATA[oMVBwxOB-mQ8Xu9CgZJ4TP76pNgo]]></FromUserName>
     *  <CreateTime>1502859301</CreateTime>
     *  <MsgType><![CDATA[text]]></MsgType>
     *  <Content><![CDATA[啊]]></Content>
     *  <MsgId>1234567890123456</MsgId>
     *  </xml>
     */
    private function responseForText($postObj)
    {
        //触发回复文本消息事件
        $event                  = new TextEvent();
        $event->toUserName      = $postObj->FromUserName;
        $event->fromUserName    = $postObj->ToUserName;
        //这里可以从数据库中查询相关关键字来获取返回的信息。
        $wechatReply = WechatReplyModel::find()->where(['AND',['status'=>WechatReplyModel::STATUS_ACTIVE],['like','input_key',trim($postObj->Content)]])->asArray()->one();

        //没有查询到关键字
        if(!$wechatReply) $this->showError();

        $event->content         = $wechatReply['result_content'];

        //触发返回文本事件
        $this->trigger(self::ECHO_TEXT,$event);
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
        //触发回复文本消息事件
        $event                  = new TextEvent();
        $event->toUserName      = $postObj->FromUserName;
        $event->fromUserName    = $postObj->ToUserName;
        $event->content         = '欢迎关注我的微信公众帐号,嘻嘻！';

        $this->trigger(self::ECHO_TEXT,$event);
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
     * 验证参数是否一致
     *
     * @param $timestamp
     * @param $nonce
     * @param $signature
     * @return bool
     */
    private function checkSignature($timestamp,$nonce,$signature)
    {
        //1.取出微信服务端和本地都商量好的token
        $token  = yii::$app->params['wechat']['token']; 

        //2.将timestamo,nonce,token按字典序排序,再把三个参数拼接,用sha1加密
        $array  = [$token,$timestamp,$nonce];//存放在数组里方便处理
        sort($array,SORT_STRING);            //字典排序
        $tmpStr = implode('',$array);       //拼接字符串
        $tmpStr = sha1($tmpStr);            //sha1加密

        //3.将加密后的字符串与signature进行对比,判断该请求是否来自微信
        if($tmpStr === $signature){
            return TRUE;
        }
        file_put_contents('wechat_error.txt', 'tmpStr:'.$tmpStr.PHP_EOL.'signature:'.$signature);
        return FALSE;
    }


    //微信返回
    private function showError(){
        echo 'success';exit();
    }
}
