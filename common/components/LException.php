<?php
namespace common\components;

use common\misc\LError;
use yii\base\Exception;

/**
 * Class LException
 * @package common\components
 */
class LException extends Exception
{
    const E_HHVM_FATAL_ERROR = 16777217;  // HHVM 引擎中的致命错误

    public function __construct($code = 0)
    {
        $message = LError::getErrMsgByCode($code);

        parent::__construct($message, $code, null);
    }

    /**
     * 检查是否致命错误
     * Returns if error is one of fatal type.
     *
     * @param array $error error got from error_get_last()
     * @return boolean if error is one of fatal type
     */
    public static function isFatalError($error)
    {
        return isset($error['type']) && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, self::E_HHVM_FATAL_ERROR]);
    }
}