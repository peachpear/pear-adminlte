<?php
defined('YII_DEBUG') or define("YII_DEBUG", false);

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
        'elkIndexName'  => [
            "error" =>  "error_demo_logs_test",
            "warning" =>  "demo_logs_test",
            "info" =>  "demo_logs_test",
            "trace" =>  "demo_logs_test",
        ],
    ]
];
list($commonBaseConfig, $commonConfig) = include(__DIR__ . '/../../common/config/test.php');
$baseConfig = include('base.php');

return [$commonBaseConfig, $commonConfig, $baseConfig, $initConfig];
