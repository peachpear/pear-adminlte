<?php
namespace common\lib;

use common\components\LKafkaProducerQueue;
use common\misc\LUtil;
use Yii;
use yii\log\Logger;
use yii\log\Target;

/**
 * Class LKafkaTarget
 * @package common\lib
 */
class LKafkaTarget extends Target
{
    /** @var  LKafkaProducerQueue */
    public $kafkaProducer;

    public function init()
    {
        parent::init();
        $this->kafkaProducer = Yii::$app->get("kafkaProducer");
    }

    /**
     * 日志数据导出
     * Exports log [[messages]] to a specific destination.
     * Child classes must implement this method.
     */
    public function export()
    {
        $text = array_map([$this, 'formatMessage'], $this->messages);
        $this->kafkaProducer->send($text);
    }

    /**
     * Formats a log message for display as a string.
     * @param array $message the log message to be formatted.
     * The message structure follows that in [[Logger::messages]].
     * @return array|string
     */
    public function formatMessage($message)
    {
        list($text, $level, $category, $timestamp) = $message;
        $indexname = "demo_logs";
        $level = Logger::getLevelName($level);
        $elkIndexName = Yii::$app->params['elkIndexName'];
        if (isset($elkIndexName[$level])) {
            $indexname = $elkIndexName[$level];
        }
        global $logId;
        global $step;
        $data = [
            "log_id"    => $logId,
            "indexname" => $indexname,
            "time"      => date('Y-m-d H:i:s', $timestamp),
            "category"  => $category,
            "level"     => $level,
            "step"      => $step++,
        ];
        if (!LUtil::isCli()) {
            $data["ip_address"] = Yii::$app->request->getUserHostAddress();
        }
        if (!is_string($text)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            if ($text instanceof \Throwable || $text instanceof \Exception) {
                $text = (string) $text;
                $data['msg'] = $text;
            } else if(is_array($text)) {
                if (isset($text['log_id'])) {
                    unset($text['log_id']);
                }
                $data = array_merge($data, $text);
            }
        } else {
            $data['msg'] = $text;
        }

        $traces = [];
        if (isset($message[4])) {
            foreach ($message[4] as $trace)
            {
                $traces[] = "in {$trace['file']}:{$trace['line']}";
            }
        }
        if ($traces) {
            $data['traces'] = $traces;
        }

        return [
            "topic" =>  "logstash",
            "value" =>  json_encode($data),
        ];
    }
}