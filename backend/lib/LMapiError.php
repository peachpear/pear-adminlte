<?php
namespace backend\lib;

use common\misc\LError;

/**
 * Class LMapiError
 * @package backend\lib
 */
class LMapiError extends LError
{
	// 重写LIB的错误提示信息，适用于MAPI
	private static $_msg = [];

    /**
     * @return array
     */
	public static function errorMsg()
	{
		return parent::mergeErrorMsg( self::$errMsg, self::$_msg );
	}
}