<?php
namespace common\lib;

use JsonSerializable;
use Yii;
use yii\db\ActiveRecord;

/**
 * ActiveRecord基类
 * Class LActiveRecord
 * @package common\lib
 */
class LActiveRecord extends ActiveRecord implements JsonSerializable
{
    const LOG_PREFIX = 'common.lib.LActiveRecord.';

    /**
     * 保存数据
     * @param bool $runValidation
     * @param null $attributeNames
     * @param int $tryNum
     * @return bool
     */
	public function save($runValidation = true, $attributeNames = null, $tryNum = 3)
	{
		if (! $this instanceof LActiveRecord || $tryNum < 1) {
			return false;
		}
		$flag = parent::save($runValidation, $attributeNames);
		if (!$flag) {
			$log = "";
			foreach ($this->getAttributes() as $key=>$value)
			{
				$log .= " ".$key.'['.$value.']';
			}

			if ($tryNum == 1) {
                Yii::error("msg[insert ".static::tableName()." table is error]{$log}",  self::LOG_PREFIX . __FUNCTION__);
            } else {
                Yii::warning("msg[insert ".static::tableName()." table is error]{$log}",  self::LOG_PREFIX . __FUNCTION__);
            }

			sleep(1);

			return self::save($runValidation, $attributeNames, --$tryNum);
		} else {
			return $flag;
		}
	}

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return $this->getAttributes();
    }
}