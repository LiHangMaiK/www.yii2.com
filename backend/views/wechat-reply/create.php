<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WechatReplyModel */

$this->title = '添加自动回复规则';
$this->params['breadcrumbs'][] = ['label' => 'Wechat Reply Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-reply-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
