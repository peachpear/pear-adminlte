<?php
namespace common\service;

use Yii;

/**
 * 请求记录日志黑名单服务类
 * Class LLogRequestBlackListService
 * @package common\service
 */
class LLogRequestBlackListService
{
    /**
     * 该url是否在请求记录的黑名单中
     * e.g. site/index
     * @param $url
     * @return bool
     */
    public static function inBlackList($url)
    {
        if (isset(Yii::$app->params['logBlackList'])) {
            $blackList = Yii::$app->params['logBlackList'];

            return in_array($url, $blackList) ? true : false;
        }

        return false;
    }
}
