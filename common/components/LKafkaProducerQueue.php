<?php
namespace common\components;

use common\misc\LUtil;
use Kafka\Producer;
use Kafka\ProducerConfig;
use yii\base\Component;

/**
 * Class LKafkaProducerQueue
 * @package common\components
 */
class LKafkaProducerQueue extends Component
{
    public $requireAck = 0;
    public $isAsyn = true;
    public $produceInterval = 5;
    public $metadata;
    public static $defaultMetadata = [
        "brokerVersion" =>  "1.0.0",
        "requestTimeoutMs"  =>  "6000",
        "refreshIntervalMs" =>  "60000",
        "maxAgeMs"          =>  "10000",
    ];
    public $timeout = 3000;
    private $clientId;
    public $messageMaxBytes = 10240;  // 10kb
    public $config;

    /**
     * 设置ClientId
     */
    public function setClientId()
    {
        if (!$this->clientId) {
            if (LUtil::isCli()) {
                $this->clientId = LUtil::getRandChar(8).":php-api:cli";
            } else {
                $this->clientId = $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].":php-api";
            }
        }
    }

    /**
     * 获取ClientId
     * @return mixed
     */
    public function getClientId()
    {
        if (!$this->clientId) {
            $this->setClientId();
        }

        return $this->clientId;
    }

    /**
     * 初始化参数
     * @param bool $force
     */
    public function initConfig($force = false)
    {
        if (!$this->config || !$this->config instanceof ProducerConfig || $force) {
            $config = ProducerConfig::getInstance();
            if (isset($this->metadata["brokerList"])) {
                $config->setMetadataBrokerList($this->metadata["brokerList"]);
            } else {
                $config->setMetadataBrokerList("192.168.40.122:9092");
            }
            if (isset($this->metadata['brokerVersion'])) {
                $config->setBrokerVersion($this->metadata['brokerVersion']);
            } else {
                $config->setBrokerVersion(self::$defaultMetadata['brokerVersion']);
            }
            if (isset($this->metadata['requestTimeoutMs'])) {
                $config->setBrokerVersion($this->metadata['requestTimeoutMs']);
            } else {
                $config->setBrokerVersion(self::$defaultMetadata['requestTimeoutMs']);
            }
            if (isset($this->metadata['refreshIntervalMs'])) {
                $config->setBrokerVersion($this->metadata['refreshIntervalMs']);
            } else {
                $config->setBrokerVersion(self::$defaultMetadata['brokerVersion']);
            }
            if (isset($this->metadata['maxAgeMs'])) {
                $config->setBrokerVersion($this->metadata['maxAgeMs']);
            } else {
                $config->setBrokerVersion(self::$defaultMetadata['maxAgeMs']);
            }
            $config->setRequiredAck($this->requireAck);
            $config->setIsAsyn($this->isAsyn);
            $config->setProduceInterval($this->produceInterval);
            $config->setTimeout($this->timeout);
            $config->setClientId($this->getClientId());
            $config->setMessageMaxBytes($this->messageMaxBytes);
            $this->config = $config;
        }
    }

    /**
     * 初始化
     */
    public function init()
    {
        parent::init();
        if (!$this->config || !$this->config instanceof ProducerConfig) {
            $this->initConfig();
        }
    }

    /**
     * 推送信息到kafka
     * @param $message
     */
    public function send($message)
    {
        if (!$this->config || !$this->config instanceof ProducerConfig) {
            $this->initConfig();
        }
        $producer = new Producer();

        return $producer->send($message);
    }
}



