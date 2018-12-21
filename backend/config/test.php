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
        'elkIndexName' =>  [
            "error" =>  "error_demo_logs_test",
            "warning" =>  "demo_logs_test",
            "info" =>  "demo_logs_test",
            "trace" =>  "demo_logs_test",
        ]
    ]
];

list($commonBaseConfig, $commonEnvConfig)= include(__DIR__ . '/../../common/config/test.php');

$baseConfig = include('base.php');

return [$commonBaseConfig, $commonEnvConfig, $baseConfig, $initConfig];
