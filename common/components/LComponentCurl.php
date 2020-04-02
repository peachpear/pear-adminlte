<?php
namespace common\components;

use yii\base\Component;

/**
 * Curl请求类
 * Class LComponentCurl
 * @package common\components
 */
class LComponentCurl extends Component
{
    private $url;
    private $ch;
    public $proxy;

    public function init()
    {
        parent::init();
        $proxyHost = isset($this->proxy['host']) && $this->proxy['host'] ? $this->proxy['host'] : '0.0.0.0';
        $proxyPort = isset($this->proxy['port']) && $this->proxy['port'] ? $this->proxy['port'] : 0;
        $this->ch = curl_init();

        // 如果有配置代理这里就设置代理
        if ($proxyHost != "0.0.0.0" && $proxyPort != 0) {
            curl_setopt($this->ch,CURLOPT_PROXY, $proxyHost);
            curl_setopt($this->ch,CURLOPT_PROXYPORT, $proxyPort);
        }
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * @param $url
     * @return bool
     */
    public function setUrl($url)
    {
        if (!$url) return false;
        if (!is_resource($this->ch)) {
            $this->init();
        }
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $this->url = $url;
    }

    /**
     * @param $array
     */
    public function setPostField($array)
    {
        if (!is_resource($this->ch)) {
            $this->init();
        }
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $array);
    }

    /**
     * @param $array
     * @return bool
     */
    public function setOptions($array)
    {
        if (!$array) return false;
        if (!is_resource($this->ch)) {
            $this->init();
        }
        curl_setopt_array($this->ch, $array);
    }

    /**
     * 执行Curl请求
     * @return mixed
     */
    public function execute()
    {
        return curl_exec($this->ch);
    }

    /**
     * @param int $type
     * @return int|NULL|string
     */
    public function getErrorInfo($type = 1)
    {
        if ($type == 1) {
            return curl_error($this->ch);
        } elseif ($type == 2) {
            return curl_errno($this->ch);
        } else {
            return curl_strerror(curl_errno($this->ch));
        }
    }

    /**
     * Curl请求close
     */
    public function close()
    {
        curl_close($this->ch);
    }

    /**
     * Curl请求解构
     */
    public function __destruct()
    {
        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }
        $this->url = "";
    }
}