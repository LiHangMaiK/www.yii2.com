<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdminModel */

$this->title = 'Create Admin Model';
$this->params['breadcrumbs'][] = ['label' => 'Admin Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
