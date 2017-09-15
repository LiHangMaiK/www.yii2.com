/**
 * Created by maikuraki on 2017/9/10.
 */

$(document).ready(function() {
    //生成二维码
    var text = 'www.baidu.com';
    $('#qrCode').qrcode({
       // render:canvas,
        render: "table",
        width: 128,
        height: 128,
        correctLevel: 0,
        text: text
    });
});