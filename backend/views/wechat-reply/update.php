<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WechatReplyModel */

$this->title = '更新规则: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wechat Reply Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wechat-reply-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
