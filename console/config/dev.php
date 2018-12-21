<?php
defined('YII_DEBUG') or define("YII_DEBUG", true);

$initConfig = [
    "components"  =>  [
        'errorHandler'  =>  [
            "sendTo"   =>  ["xxx1@demo.com","xxx2@demo.com"],
            "sendCC"    =>  [
                "xxxx@demo.com"=>"xxxx",
            ],
        ],
    ],
    "params"    =>  [
        'elkIndexName' => [
            "error" =>  "error_demo_logs_dev",
            "warning" =>  "demo_logs_dev",
            "info" =>  "demo_logs_dev",
        ],
    ]
];

list($commonBaseConfig, $commonConfig) = include(__DIR__ . '/../../common/config/dev.php');
$baseConfig = include('base.php');

return [$commonBaseConfig, $commonConfig, $baseConfig, $initConfig];