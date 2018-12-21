<?php
namespace common\components;

use Yii;
use yii\base\Component;

/**
 * Class LRabbitQueue
 * @package common\components
 */
class LRabbitQueue extends Component
{
    const LOG_PREFIX = 'common.components.LRabbitQueue.';
    private $connection;
    public $credentials;

    public function init()
    {

    }

    /**
     * 初始化连接
     */
    public function initConnection()
    {
        if (!$this->connection || !is_resource($this->connection)) {
            $this->connection = new \AMQPConnection($this->credentials);
        }
        if (!$this->connection->isConnected()) {
            $this->connect();
        }
    }

    /**
     * @param int $tryNum
     * @throws \Exception
     */
    public function connect($tryNum = 3)
    {
        try {
            $this->connection->connect();
        } catch(\Exception $e) {
            if (--$tryNum) {
                Yii::warning("msg[".$e->getMessage()."]", self::LOG_PREFIX . __FUNCTION__);
                sleep(1);
                $this->connect($tryNum);
            } else {
                Yii::error("msg[".$e->getMessage()."]", self::LOG_PREFIX . __FUNCTION__);
                throw $e;
            }
        }
    }

    /**
     * 获取连接
     * @return mixed
     */
    public function getConnection()
    {
        $this->initConnection();

        return $this->connection;
    }

    /**
     * 向队列推送数据
     * @param $message
     * @param $exchange
     * @param $routing
     * @return bool
     */
    public function produce($message, $exchange, $routing)
    {
        $message = json_encode($message);

        $channel = new \AMQPChannel($this->getConnection());
        $ex = new \AMQPExchange($channel);
        $ex->setName($exchange);
        $ex->setType(AMQP_EX_TYPE_DIRECT);
        $ex->setFlags(AMQP_DURABLE);

        $ex->declareExchange();

        if (!$ex->publish($message, $routing, 1, ['delivery_mode' => 2])) {
            return false;
        }

        return true;
    }

    /**
     * 向队列批量推送数据
     * @param $messageList
     * @param $exchange
     * @param $routing
     * @return bool
     */
    public function batchProduce($messageList, $exchange, $routing)
    {
        $channel = new \AMQPChannel($this->getConnection());
        $ex = new \AMQPExchange($channel);
        $ex->setName($exchange);
        $ex->setType(AMQP_EX_TYPE_DIRECT);
        $ex->setFlags(AMQP_DURABLE);

        $ex->declareExchange();

        foreach ($messageList as $message) {
            $messageJson = json_encode($message);

            if (!$ex->publish($messageJson, $routing, 1, ['delivery_mode' => 2])) {
                return false;
            }
        }

        return true;
    }

    /**
     * 通用延迟消费进队方法,消息持久化
     * @param $message
     * @param $exchange
     * @param $routing
     * @param $ttl    消息生存时间(1000 = 1s)
     * @return bool
     */
    public function produceTtl($message, $exchange, $routing, $ttl)
    {
        $message = json_encode($message);

        $channel = new \AMQPChannel($this->getConnection());
        $ex = new \AMQPExchange($channel);
        $ex->setName($exchange);
        $ex->setType(AMQP_EX_TYPE_DIRECT);
        $ex->setFlags(AMQP_DURABLE);

        $ex->declareExchange();

        $argument = array(
            'delivery_mode' => 2,
            'expiration' => $ttl
        );

        if (!$ex->publish($message, $routing, 1, $argument)) {
            return false;
        }

        return true;
    }
}