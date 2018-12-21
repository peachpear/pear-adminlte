<?php
namespace common\components;

use peachpear\pearLeaf\ConfigService;
use Yii;
use yii\console\Application;
use yii\helpers\ArrayHelper;

/**
 * Class LConsoleApplication
 * @package common\components
 */
class LConsoleApplication extends Application
{
    /**
     * 应用构建
     * 配置从服务器重载
     * LConsoleApplication constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        ini_set("display_errors", true);
        $this->initAliases($config);

        // 加载配置中心文件，替换config
        if (!empty($config["configCenter"]))
        {
            $filePath = $config["ConfigService"]["filePath"];
            $fileExtension = $config["ConfigService"]["fileExt"];
            $configService = ConfigService::getInstance($filePath, $fileExtension);
            $configService->loadJson($config);
            $config = ArrayHelper::merge($config, $configService->getConfig());
            unset($config["configCenter"]);
        }

        parent::__construct($config);
    }

    /**
     * @param $config
     */
    public function initAliases(&$config)
    {
        if (isset($config['aliases'])) {
            foreach ($config['aliases'] as $key=>$value)
            {
                Yii::setAlias($key, $value);
            }
            unset($config['aliases']);
        }
        $this->enableCoreCommands = false;
    }
}