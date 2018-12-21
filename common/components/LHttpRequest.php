<?php
namespace common\components;

use common\misc\LUtil;
use Yii;
use yii\web\Request;

/**
 * Request请求类
 * Class LHttpRequest
 * @package common\components
 */
class LHttpRequest extends Request
{
	const LOG_PREFIX = 'common.components.LHttpRequest.';
    const TYPE_STRING = 1;
    const TYPE_INTEGER = 2;
    const TYPE_ARRAY = 3;

    /**
     * 获取用户IP地址
     * @return string
     */
	public function getUserHostAddress()
	{
		if (!empty($_SERVER['RAW_REMOTE_ADDR'])) {
			$_SERVER["REMOTE_ADDR"] = $_SERVER['RAW_REMOTE_ADDR'];
		} elseif (isset($_SERVER['HTTP_CDN_SRC_IP'])) {
			list($_SERVER["REMOTE_ADDR"]) = explode(',', $_SERVER["HTTP_CDN_SRC_IP"]);
			$_SERVER["REMOTE_ADDR"] = trim($_SERVER["REMOTE_ADDR"]);
		} elseif (!isset($_SERVER['REMOTE_ADDR']) || LUtil::isLAN($_SERVER['REMOTE_ADDR'])) {
			if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				list($_SERVER["REMOTE_ADDR"]) = explode(',', $_SERVER["HTTP_X_FORWARDED_FOR"]);
				$_SERVER["REMOTE_ADDR"] = trim($_SERVER["REMOTE_ADDR"]);
			}
		}

		return $_SERVER["REMOTE_ADDR"];
	}

    /**
     * 重写获取用户请求路径
     * @return string
     * e.g. site/index
     */
	public function getPathInfo()
    {
	    $pathInfo = parent::getPathInfo();

        return rtrim($pathInfo, "/");
    }
}
