<?php
namespace common\components;

use common\misc\LError;
use Yii;
use yii\web\Application;
use yii\web\ErrorHandler;
use yii\web\HttpException;

/**
 * ErrorHandler处理类
 * Class LErrorHandler
 * @package common\components
 */
class LErrorHandler extends ErrorHandler
{
    /**
     * 渲染异常
     * @param \Error|\Exception $exception
     */
    public function renderException($exception)
    {
        $this->handleException($exception);
    }

    /**
     * 异常处理
     * $data['code'] ? $data['code'] : 500
     * @param $exception
     */
	public function handleException($exception)
	{
	    if (YII_DEBUG) {
	        ini_set("display_errors", true);

	        throw $exception;
        }

		$data = $this->formatException($exception);

        /** @var $app Application */
        $app = Yii::$app;
        /** @var $controller LController */
        $controller = $app->controller;

        if (!$controller instanceof LController) {
            $controller = $app->createController('site');
            $controller = $controller[0];
        }

        $this->logException($exception);

        $controller->ajaxReturn(
            (isset($data['errorCode']) ? $data['errorCode'] : $data['code']) ? $data['code'] : 500,
            YII_DEBUG ? $data['message'] : array(),
            YII_DEBUG ? $data : array()
        );
	}

    /**
     * 错误处理
     */
	public function handleError($code, $message, $file, $line)
	{
        /** @var $app Application */
        $app = Yii::$app;
        /** @var $controller LController */
        $controller = $app->controller;

        if (!$controller instanceof LController) {
            $controller = $app->createController('/site');
            $controller = $controller[0];
        }

        $exception =  new \ErrorException($message, $code, 1, $file, $line);

        $this->logException($exception);

        if (YII_DEBUG) {
            throw $exception;
        }

        $data = ["msg" => "file:".$file.",line:".$line];

        $controller->ajaxReturn(
            LError::INTERNAL_ERROR,
            YII_DEBUG ? $message : array(),
            YII_DEBUG ? $data : array()
        );
	}

    /**
     * 格式化异常
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
			'code' => ($exception instanceof HttpException) ? $exception->statusCode : 500,
			'type' => get_class($exception),
			'errorCode' => $exception->getCode(),
			'message' => $exception->getMessage(),
			'file' => $fileName,
			'line' => $errorLine,
			'trace' => $exception->getTraceAsString(),
//			'traces' => $trace,
		);
	}

    /**
     * 致命错误处理
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
            // need to explicitly flush logs because exit() next will terminate the app immediately
            Yii::getLogger()->flush(true);

            $this->handleException($exception);
        }
    }
}