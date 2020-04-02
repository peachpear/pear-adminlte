<?php
defined("ENV") || define("ENV", "test");
$baseConfig = include('base.php');

$commonConfig = array(
    'components' => [
        'cache' => [
            'host' => '',
            'port' => 6379,
            'keyPrefix' => '',
        ],
        'demoDB'  => [
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
    "configService" => [
        "filePath" => "/config/test/",
        "fileExt" => "json",
    ]
);

return [$baseConfig, $commonConfig];
