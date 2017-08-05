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
    //添加版本模块
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        //配置后台管理员映射数据库哪张表(AdminModel)
        'user' => [
            'identityClass' => 'common\models\AdminModel',
            'enableAutoLogin' => true,//开启自动登录，AdminModel中要实现一些接口。
            'enableSession'=>false
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' =>true,
            'rules' => [
                [
                'class' => 'yii\rest\UrlRule',
                'controller' => ['v1/goods']
//                'extraPatterns' => [
//                    'POST modify/<id:\d+>' => 'modify',
//                    ]
                ],
            ]
        ]
    ],
    'params' => $params,
];
