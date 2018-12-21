<?php
defined('YII_DEBUG') or define("YII_DEBUG", false);

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
        'elkIndexName' => [
            "error" =>  "error_demo_logs_pre",
            "warning" =>  "demo_logs_pre",
            "info" =>  "demo_logs_pre",
            "trace" =>  "demo_logs_pre",
        ]
    ]
];

list($commonBaseConfig, $commonEnvConfig)= include(__DIR__ . '/../../common/config/pre.php');

$baseConfig = include('base.php');

return [$commonBaseConfig, $commonEnvConfig, $baseConfig, $initConfig];