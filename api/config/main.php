<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        //配置后台管理员映射数据库哪张表(AdminModel)
        'user' => [
            'identityClass' => 'common\models\UserModel',
            'enableAutoLogin' => true,//开启自动登录，AdminModel中要实现一些接口。
            'enableSession'=>false,
//            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        //路由配置
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,//是否显示脚本名（index.php）
            'enableStrictParsing' =>true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/Goods']
                ],
//                [
//                    'class' => 'yii\rest\UrlRule',
//                    'controller' => ['v2/goods']
//                ],
//                [
//                    'class' => 'yii\rest\UrlRule',
//                    'controller' => ['v1/User']
//                ],
            ],
        ],
    ],
    'params' => $params,
];
