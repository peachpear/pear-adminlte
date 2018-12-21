<?php
defined("ENV") || define("ENV", "pre");
$baseConfig = include('base.php');

$commonConfig = array(
    'components' => [
        'cache' => [
            'host' => '',
            'port' => 6379,
            'keyPrefix' => '',
        ],
        'demoDB'  => [
            'class' => '\yii\db\Connection',
            'charset' => 'utf8mb4',
            'dsn' => '',
            'username' => '',
            'password' => '',
        ],
        'kafkaProducer' => [
            "metadata" => [
                "brokerList" => "192.168.40.122:9200",
            ],
            "requireAck" => 0,
        ],
        'queue' => [
            'credentials' => [
                'host' => '',
                'port' => '5672',
                'login' => '',
                'password' => ''
            ]
        ],
    ],
    'params' => [],
    "configCenter" => [
        "filePath" => "/config/pre/",
        "fileExt" => "json",
    ]
);

return [$baseConfig, $commonConfig];
