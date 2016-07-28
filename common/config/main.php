<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //'db' => [
          //  'class' => 'yii\db\Connection',
          //  'dsn' => 'mysql:host=192.168.1.35;dbname=chang_dev',
           // 'username' => 'changadm_dev',
           // 'password' => 'changdb123',
          //  'charset' => 'utf8',
       // ],
    ],
];
