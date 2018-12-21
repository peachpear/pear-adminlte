<?php
use common\components\LConsoleApplication;

$logId = uniqid() . mt_rand(100000, 999999);
$step = 1;
list($commonBaseConfig, $commonConfig, $baseConfig, $initConfig) = include_once(__DIR__ . "/../console/config/main.php");
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__."/../common/components/LConsoleApplication.php");
$config = yii\helpers\ArrayHelper::merge($commonBaseConfig, $commonConfig, $baseConfig, $initConfig);
$application = new LConsoleApplication($config);
$application->run();
