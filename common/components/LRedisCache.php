<?php
namespace common\components;

use common\misc\LError;
use Redis;
use Yii;
use yii\caching\Cache;
use yii\helpers\StringHelper;

/**
 * To use LRedisCache as the cache application component, configure the application as follows,
 * <pre>
 * array(
 *     'components'=>array(
 *         'cache'=>array(
 *             'class'=>'LRedisCache',
 *             'host'=>'server1',
 *             'port'=>11211,
 *         ),
 *     ),
 * )
 * </pre>
 *
 * @property Redis $redis The Redis instance used by this component.
 *
 * @package common.components
 */
class LRedisCache extends Cache
{
	const LOG_PREFIX = 'common.components.LRedisCache.';

	/**
	 * @var  Redis the redis  instance
	 */
	private $_cache = null;

	/**
	 * @var string host
	 */
	public $host = "";

	public $port = "";

	protected $_options = array();

	protected $_ping = false;

	public $hashKey = true;

	public $database = 0;

	public $password = "";

	/**
	 * Initializes this application component.
	 * This method is required by the {@link IApplicationComponent} interface.
	 * It creates the redis array instance.
	 * @throws LException if extension isn't loaded
	 */
	public function init()
	{
		parent::init();
		$this->getRedis();
	}

	/**
	 * @return Redis this redis array instance used by this component.
	 * @throws LException if extension isn't loaded
	 */
	public function getRedis()
	{
		if ($this->_cache === null) {
			if (!extension_loaded('redis')) {
				Yii::Error("LRedisCache requires PHP redis extension to be loaded", self::LOG_PREFIX . __FUNCTION__);
				throw new LException(LError::INTERNAL_ERROR);
			}

            $this->_cache = new Redis();
            $this->_cache->connect($this->host, $this->port);

            if ($this->password) {
                $this->_cache->auth($this->password);
            }
			if ($this->database) {
			    $this->_cache->select($this->database);
            }
		}

		return $this->_cache;
	}

	/**
	 * @return array options for connecting to redis server
	 */
	public function getOptions()
	{
		return $this->_options;
	}

	/**
	 * @param array $options options for connecting to redis server.
	 * @see https://github.com/nicolasff/phpredis/blob/master/arrays.markdown
	 */
	public function setOptions($options)
	{
		$this->_options = $options;
	}

	public function getPing()
	{
		return $this->_ping;
	}

	public function setPing($ping)
	{
		$this->_ping = $ping;
	}

	/**
	 * Retrieves a value from cache with a specified key.
	 * This is the implementation of the method declared in the parent class.
	 * @param string $key a unique key identifying the cached value
	 * @return string|boolean the value stored in cache, false if the value is not in the cache or expired.
	 */
	protected function getValue($key)
	{
		if ($this->_ping)
		{
			$this->checkConnection();
		}
		return $this->_cache->get($key);
	}

	protected function checkConnection()
	{
		$this->_cache->ping();
		//Yii::log("redis ping", CLogger::LEVEL_TRACE, self::LOG_PREFIX . __FUNCTION__);
	}

	/**
	 * Retrieves multiple values from cache with the specified keys.
	 * @param array $keys a list of keys identifying the cached values
	 * @return array a list of cached values indexed by the keys
	 */
	protected function getValues($keys)
	{
		if ($this->_ping) {
			$this->checkConnection();
		}
		$response = $this->_cache->mGet($keys);
		$result=array();
		$i=0;
		foreach($keys as $key)
        {
            $result[$key] = $response[$i++];
        }

		return $result;
	}

	/**
	 * Stores a value identified by a key in cache.
	 * This is the implementation of the method declared in the parent class.
	 *
	 * @param string $key the key identifying the value to be cached
	 * @param string $value the value to be cached
	 * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
	 * @return boolean true if the value is successfully stored into cache, false otherwise
	 */
	protected function setValue($key, $value, $expire)
	{
		if ($this->_ping) {
			$this->checkConnection();
		}

        // 兼容PHP7
        if ($expire <= 0) {
            $result = $this->_cache->set($key, $value);
        } else {
            $result = $this->_cache->set($key, $value, $expire);
        }

		if ($result !== true) {
			Yii::Error("save key[" . $key . "] failed", "common.components.LRedisCache.setValue");

			return false;
		}

		return true;
	}

	/**
	 * Stores a value identified by a key into cache if the cache does not contain this key.
	 * This is the implementation of the method declared in the parent class.
	 *
	 * @param string $key the key identifying the value to be cached
	 * @param string $value the value to be cached
	 * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
	 * @return boolean true if the value is successfully stored into cache, false otherwise
	 */
	protected function addValue($key, $value, $expire)
	{
		if ($expire <= 0) {
			$expire = 0;
		}

		if ($this->_ping) {
			$this->checkConnection();
		}

		return $this->_cache->set($key, $value, array('nx', 'ex' => $expire));
	}

	/**
	 * Deletes a value with the specified key from cache
	 * This is the implementation of the method declared in the parent class.
	 * @param string $key the key of the value to be deleted
	 * @return boolean if no error happens during deletion
	 */
	protected function deleteValue($key)
	{
		if ($this->_ping) {
			$this->checkConnection();
		}

		return $this->_cache->delete($key) == 1;
	}

	/**
	 * Deletes all values from cache.
	 * This is the implementation of the method declared in the parent class.
	 * @return boolean whether the flush operation was successful.
	 * @since 1.1.5
	 */
	protected function flushValues()
	{
		if ($this->_ping) {
			$this->checkConnection();
		}

		return $this->_cache->flushdb();
	}

    public function buildKey($key)
    {
        if ($this->hashKey) {
            if (is_string($key)) {
                $key = ctype_alnum($key) && StringHelper::byteLength($key) <= 32 ? $key : md5($key);
            } else {
                $key = md5(json_encode($key));
            }
        }

        return $this->keyPrefix . $key;
    }

	public function hExists($key,$hashKey)
    {
        /** @var Redis $cache */
        $cache  = $this->_cache;
        return $cache->hExists($this->buildKey($key), $hashKey);
    }

    public function incr($key)
    {
        return  $this->_cache->incr($this->buildKey($key));
    }
}