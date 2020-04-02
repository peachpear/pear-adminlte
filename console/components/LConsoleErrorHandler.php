<?php
namespace console\components;

use common\components\LException;
use common\components\LRabbitQueue;
use Yii;
use yii\console\ErrorHandler;

/**
 * 命令行错误处理
 * Class LConsoleErrorHandler
 * @package console\components
 */
class LConsoleErrorHandler extends ErrorHandler
{
    public $sendTo;
    public $sendCC;

    /**
     * 处理异常
     * 覆盖父类定义 yii\base\ErrorHandler->handleException()
     * set_exception_handler([$this, 'handleException']);
     * @param $exception
     */
    public function handleException($exception)
    {
        // 日志记录错误异常
        $this->logException($exception);

        // 渲染输出错误异常
        $this->renderException($exception);
    }

    /**
     * 处理错误
     * 覆盖父类定义 yii\base\ErrorHandler->handleError()
     * set_error_handler([$this, 'handleError']);
     * @param $code
     * @param $message
     * @param $file
     * @param $line
     */
    public function handleError($code, $message, $file, $line)
    {
        $exception =  new \ErrorException($message, $code, 1, $file, $line);
        $this->handleException($exception);
    }

    /**
     * 处理致命错误
     * 覆盖父类定义 yii\base\ErrorHandler->handleFatalError()
     * register_shutdown_function([$this, 'handleFatalError']);
     */
    public function handleFatalError()
    {
        $error = error_get_last();
        if (LException::isFatalError($error)) {
            $exception = new \ErrorException($error['message'], 500, $error['type'], $error['file'], $error['line']);
            $this->exception = $exception;

            $this->logException($exception);

            if ($this->discardExistingOutput) {
                $this->clearOutput();
            }
            $this->renderException($exception);

            // need to explicitly flush logs because exit() next will terminate the app immediately
            Yii::getLogger()->flush(true);
        }
    }

    /**
     * 渲染输出错误异常
     * 覆盖父类定义 yii\console\ErrorHandler->renderException()
     * @param $exception
     */
    public function renderException($exception)
    {
        $data = $this->formatException($exception);

        // 发邮件
        if (YII_DEBUG) {
            throw $exception;
        } else {
            $this->sendErrorMsg($data);
        }
    }

    /**
     * 把错误异常信息推入mail队列，发邮件提醒项目负责人
     * @param $data
     * @internal param $exception
     */
    public function sendErrorMsg($data)
    {
        /** @var LRabbitQueue $queue */
        $queue = Yii::$app->get("queue");
        $params = [
            'send_to' => $this->sendTo,
            'cc_to' => $this->sendCC,
            'text' => json_encode($data),
            'title' => "[".ENV.']cli-exception-error',
            'file' => []
        ];
        $queue->produce($params, 'async', 'mail');
    }

    /**
     * 格式化异常/错误信息
     * @param $exception
     * @return array
     */
    protected function formatException($exception)
    {
        $fileName = $exception->getFile();
        $errorLine = $exception->getLine();

        $trace = $exception->getTrace();

        foreach ($trace as $i => $t)
        {
            if (!isset($t['file'])) {
                $trace[$i]['file'] = 'unknown';
            }

            if (!isset($t['line'])) {
                $trace[$i]['line'] = 0;
            }

            if (!isset($t['function'])) {
                $trace[$i]['function'] = 'unknown';
            }

            unset($trace[$i]['object']);
        }

        return array(
            'type' => get_class($exception),
            'errorCode' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $fileName,
            'line' => $errorLine,
            'trace' => $exception->getTraceAsString(),
//            'traces' => $trace,
        );
    }
}