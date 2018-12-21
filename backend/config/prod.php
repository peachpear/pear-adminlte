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
            "error" =>  "error_demo_logs",
            "warning" =>  "demo_logs",
            "info" =>  "demo_logs",
            "trace" =>  "demo_logs",
        ]
    ]
];

list($commonBaseConfig, $commonEnvConfig)= include(__DIR__ . '/../../common/config/prod.php');

$baseConfig = include('base.php');

return [$commonBaseConfig, $commonEnvConfig, $baseConfig, $initConfig];
