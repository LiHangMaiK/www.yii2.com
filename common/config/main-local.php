<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2blog',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'tablePrefix' => 'blog_',
            //开启Schema缓存，原理是对数据库对象的集合进行缓存，这样我们操作AR的时候就可以重用。
            //注意：组件里面要定义一个cache来缓存此数据(FileCache)。另外，改了数据库结构要关闭此缓存，然后再开启。
            'enableSchemaCache' => false,
            'schemaCacheDuration' => 24*3600,
            'schemaCache' => 'cache',
        ],
        //缓存配置
        'cache' => [
           // 'class' => 'yii\caching\FileCache',
            'class' => 'yii\redis\Cache',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '192.168.50.100',
            'port' => 7200,
            'database' => 0,
        ],
    ],
];
