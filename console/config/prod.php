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
            "error" =>  "error_demo_logs",
            "warning" =>  "demo_logs",
            "info" =>  "demo_logs",
            "trace" =>  "demo_logs",
        ],
    ]
];
list($commonBaseConfig, $commonConfig) = include(__DIR__ . '/../../common/config/prod.php');
$baseConfig = include('base.php');

return [$commonBaseConfig, $commonConfig, $baseConfig, $initConfig];
