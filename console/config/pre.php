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
        'elkIndexName' => [
            "error" =>  "error_demo_logs_pre",
            "warning" =>  "demo_logs_pre",
            "info" =>  "demo_logs_pre",
            "trace" =>  "demo_logs_pre",
        ],
    ]
];
list($commonBaseConfig, $commonConfig) = include(__DIR__ . '/../../common/config/pre.php');
$baseConfig = include('base.php');

return [$commonBaseConfig, $commonConfig, $baseConfig, $initConfig];
