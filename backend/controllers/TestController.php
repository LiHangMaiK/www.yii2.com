<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/9/10
 * Time: 16:06
 */

namespace backend\controllers;

use yii;
use yii\web\Controller;
use PHPQRCode\QRcode;

class TestController extends Controller
{
    //生成二维码
    public function actionIndex(){

        //普通链接
        $content            = 'https://www.baidu.com';//二维码链接

        //v_card个人名片，微信可用，格式如下:
        //N 姓，FN 名,ORG 公司地址,
        //TEL;WORK;VOICE 工作单位电话
        //TEL;HOME;VOICE 家里电话
        //TEL;TYPE=cell 移动电话
        //ADR;HOME 家庭住址
        //EMAIL 邮箱
        //URL 网址
//        $content            = '';
//        $content           .= 'BEGIN:VCARD'."\n";
//        $content           .= 'VERSION:2.1'."\n";
//        $content           .= 'N:李'."\n";
//        $content           .= 'FN:航'."\n";
//        $content           .= 'TEL;TYPE=cell:18202811032'."\n";
//        $content           .= 'END:VCARD'."\n";

        $filePath           = 'baidu.jpg';//保存路径,若值为false表示只输出不保存。
        //纠错能力：L级(0)：约可纠错7%的数据码字,
        //M级(1)：约可纠错15%的数据码字,
        //Q级(2)：约可纠错25%的数据码字,
        //H级(3)：约可纠错30%的数据码字
        $level              = 0;
        $size               = '4';//兼容移动端，4比较好。
        $margin             = '2';//外边距，空白选择2较少。
        $saveAndPrint       = true;//同时打印和保存。

//        QRcode::png('https://www.baidu.com',false,$level,$size,$margin);exit();
        QRcode::png($content,$filePath,$level,$size,$margin,$saveAndPrint);exit();

        return $this->render('index');
    }

    //识别二维码要用到：
    //1.ImageMagick 基础图片处理工具
    //2.zbar 图片识别软件，核心工具
    //3.php-zbarcode PHP基于zbar的扩展。


}