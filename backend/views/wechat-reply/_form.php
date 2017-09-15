<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\WechatReplyModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-reply-model-form">

    <?php $form = ActiveForm::begin([
        'id' => 'wechat-reply-model-id',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form']),
    ]); ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'input_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'result_content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'add_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
