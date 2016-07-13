<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.1.35;dbname=chang_dev',
            'username' => 'changadm_dev',
            'password' => 'changdb123',
            'charset' => 'utf8',
        ],
    ],
];
