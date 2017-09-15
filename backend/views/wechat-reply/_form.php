<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;

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

    <?= $form->field($model, 'status')->dropDownList(['1'=>'启用','0'=>'禁用']) ?>

    <?= $form->field($model, 'input_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'result_content')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
