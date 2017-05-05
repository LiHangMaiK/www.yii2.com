<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\AdminModel */

$this->title = '添加新管理员';
$this->params['breadcrumbs'][] = ['label' => '管理员模块', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backend-signup">
    <div class="row">
        <div class="col-md-8 col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<!--    <?//= $form->field($model, 'email')->label('邮箱') ?>        -->
            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'repassword')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
