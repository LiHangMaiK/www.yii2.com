<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/5/8
 * Time: 15:23
 */

namespace common\components;

class Helper
{
    public static function MyPrint($result)
    {
        echo '<pre>';print_r($result);exit();
    }

    public static function MyVarDump($result)
    {
        var_dump($result);exit();
    }

    public static function getCurlOutput($url,$isPost = false,$postData = array()){

        //初始化
        $ch = curl_init();

        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //post请求
        if($isPost && $postData){
            curl_setopt($ch, CURLOPT_POST, 1);
            //post的变量
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);

        //如果报错
        if(curl_errno($ch)){
            var_dump(curl_error($ch));exit();
        }

        //释放curl句柄
        curl_close($ch);

        //返回结果
        return $output;

    }
}