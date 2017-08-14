<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cQApMO3aiI0s-SIFgC0LrgI6YxXhEufk',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    //debug模块
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//    ];
    //gii模块
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'crud' => [ //生成器名称
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [ //设置我们自己的模板
                    //模板名 => 模板路径
                    'myCrud' => '@backend/components/gii-custom/crud/default',
                ]
            ]
        ],
    ];
}

return $config;
