<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    //配置语言
    'language' => 'zh-CN', //使用哪种语言包，默认英文，搭配i18n用。
    //配置时区
    'timeZone'=>'Asia/Chongqing',
    'components' => [
        //缓存配置
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //语言包配置
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource', //使用php代码文件包
                    'basePath' => '@app/messages',//默认根目录下的message文件夹下
                    'fileMap' => [
                        'common' => 'common.php',
//                        'test'   => 'test.php',
// 不同模块的语言包分开放置，在根目录下message/zh-CN文件夹里面创建相对应的php文件，格式一样就行。使用Yii::t('test','xxx');
                    ],
                ],
            ],
        ],
        //路由配置
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'suffix' => '.html',
            'rules' => [
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            ],
        ],
        //authManager有PhpManager和DbManager两种方式,
        //PhpManager将权限关系保存在文件里,这里使用的是DbManager方式,将权限关系保存在数据库.
        //RBAC权限管理模块
        "authManager" => [
            "class" => 'yii\rbac\DbManager',
        ],
    ],
];
