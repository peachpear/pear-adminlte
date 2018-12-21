<?php
defined('YII_DEBUG') or define("YII_DEBUG", true);
ini_set("display_errors", true);

$initConfig = [
    "components"  =>  [
        'log' => [
            'targets' => [
                'kafka'  =>
                    [
                        'levels' => ['error', 'warning', "trace"],
                        'logVars'=>[],
                    ],
            ]
        ],
    ],
    "params"    =>  [
        'elkIndexName'  =>  [
            "error" =>  "error_demo_logs_dev",
            "warning" =>  "demo_logs_dev",
            "info" =>  "demo_logs_dev",
            "trace" =>  "demo_logs_dev",
        ],
    ],
];

list($commonBaseConfig, $commonEnvConfig) = include(__DIR__ . '/../../common/config/dev.php');

$baseConfig = include('base.php');

return [$commonBaseConfig, $commonEnvConfig, $baseConfig, $initConfig];
