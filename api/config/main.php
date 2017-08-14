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
            'identityClass' => 'common\models\UserModel',
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
        //404页面
        'errorHandler' => [
            'errorAction' => 'v1/default/error',
        ],
        //restfulAPI路由管理
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' =>true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/goods',
                        'v1/users'
                    ],
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'GET signup-test' => 'signup-test',
                        'GET user-test' => 'user-test'
                    ]
                ],
            ]
        ],
        //设置服务端返回格式为json格式，固定。
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->data = [
                    'code' => $response->getStatusCode(),
                    'data' => $response->data,
                    'msg' => $response->statusText
                ];
                $response->format = yii\web\Response::FORMAT_JSON;
            },
        ],
    ],
    'params' => $params,
];
