<?php
ini_set("date.timezone", "Asia/shanghai");
$logId = uniqid() . mt_rand(100000, 999999);
$step = 1;
list($commonBaseConfig, $commonEnvConfig, $baseConfig, $initConfig) = include_once(__DIR__ . "/../config/main.php");
require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__."/../../common/components/LApplication.php");
$config = yii\helpers\ArrayHelper::merge($commonBaseConfig, $commonEnvConfig, $baseConfig, $initConfig);
$application = new common\components\LApplication($config);
$application->run();
