<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/9/10
 * Time: 16:07
 */

$this->title = '';
\backend\assets\AppAsset::addScript($this,'@web/static/js/qrcode.js');
?>
<div>
    <div id="qrCode"></div>
</div>