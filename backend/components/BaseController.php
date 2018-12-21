<?php
namespace backend\components;

use common\components\LController;
use common\components\LHttpRequest;
use common\service\LLogRequestBlackListService;
use Yii;
use yii\log\Logger;

/**
 * Class BaseController
 * @package backend\components
 */
abstract class BaseController extends LController
{
    /** @var  LHttpRequest */
    public $request;

	public function init()
	{
		parent::init();

		// 写入日志
        $pathInfo = Yii::$app->request->getPathInfo();
        if ( !LLogRequestBlackListService::inBlackList($pathInfo) ) {
            $name = "POST";
            if (Yii::$app->request->getIsGet()) {
                $data = Yii::$app->request->get();
                $name = "GET";
            } else {
                $data = Yii::$app->request->post();
            }
            $context["requestBody"] = json_encode($data);
            $context["methodVar"] = $name;
            $context['actionUrl'] = Yii::$app->request->getUrl();

            Yii::getLogger()->log($context, Logger::LEVEL_TRACE, "application");
        }

        $this->request = Yii::$app->request;
	}

    /**
     * 获取用户IP
     * @return null|string
     */
	protected function getUserIp()
	{
		return isset($_SERVER['RAW_REMOTE_ADDR']) ? $_SERVER['RAW_REMOTE_ADDR'] : Yii::$app->request->getUserIP();
	}
}
