<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('common',"MinMin's Blog"),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $leftItems = [
        ['label' => Yii::t('common','Home'), 'url' => ['/site/index']],
        ['label' => Yii::t('common','Article'), 'url' => ['/article/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $rightItems[] = ['label' => Yii::t('common','Signup'), 'url' => ['/site/signup']];
        $rightItems[] = ['label' => Yii::t('common','Login'), 'url' => ['/site/login']];
    } else {
//        $rightItems[] = '<li>'
//            . Html::beginForm(['/site/logout'], 'post')
//            . Html::submitButton(
//                '<img src="static/images/avatar/myAvatar.jpg" alt='.Yii::$app->user->identity->username.'>',
//                ['class' => 'btn btn-link logout']
//            )
//            . Html::endForm()
//            . '</li>';
        $rightItems[] = [
            'label' => '<img src='.Yii::$app->params['avatar']['small'].' alt='.Yii::$app->user->identity->username.'>',
            'linkOptions' => ['class' => 'avatar'],
            'items' => [
                [
                    'label' => '<i class="fa fa-sign-out"></i> '.Yii::t('common','Logout'),
                    'url'   => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
                [
                    'label' => '<i class="fa fa-user-circle-o"></i> '.Yii::t('common','personal center'),
                    'url'   => '#',
                    'linkOptions' => ['data-method' => 'post']
                ],
                //多个item
                //...
            ],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftItems,
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false, //标签不会被编码解释，可以输出html。
        'items' => $rightItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Blog <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::$app->params['adminEmail'] ?></p>
<!--        <p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
