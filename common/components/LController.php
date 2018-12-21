<?php
namespace common\components;

use common\misc\LError;
use common\service\LLogRequestBlackListService;
use stdClass;
use Yii;
use yii\log\Logger;
use yii\web\Controller;
use yii\web\Response;

/**
 * Controller基类
 * Class LController
 * @package common\components
 */
class LController extends Controller
{
    /**
     * ajax输出
     * @param array $result
     */
    public function ajaxResponse($result = [])
    {
        /** @var LHttpRequest $request */
        $request = Yii::$app->request;
        /** @var Response $response */
        $response = Yii::$app->response;

        $callback = $request->get('callback');
        if (empty($result)) {
            $result = new stdClass();
        }

        if ($callback && is_string($callback) && preg_match('/^[0-9A-Za-z_]+$/', $callback)) {
            $response->format = Response::FORMAT_JSONP;
            $response->content = 'try{' . $callback . '(' . json_encode($result) . ');}catch(e){}';
        } else {
            $response->format = Response::FORMAT_JSON;
            $response->content = json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        // 记录日志
        $pathInfo = Yii::$app->request->getPathInfo();
        if (!LLogRequestBlackListService::inBlackList($pathInfo)) {
            $context['actionUrl'] = Yii::$app->request->getUrl();
            $context['result'] = $result;
            if ($context["result"]["data"]) {
                $context["result"]["data"] = json_encode($context["result"]["data"]);
            }

            Yii::getLogger()->log($context, Logger::LEVEL_TRACE, "application");
        }

        Yii::$app->end(0, $response);
    }

    /**
     * ajax返回
     * @param int $code
     * @param array|string $msg
     * @param $data
     */
    public function ajaxReturn($code = LError::SUCCESS, $msg = array(), $data = null)
    {
        if (is_array($msg) || !$msg) {
            $msg = LError::getErrMsgByCode($code, $msg);
        }

        if (is_null($data)) {
            $data = new stdClass();
        } elseif (!$data) {
            $data = [];
        }

        $this->ajaxResponse([
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ]);
    }

    /**
     * ajax返回成功信息
     * @param array $data
     */
    public function ajaxSuccess(array $data = [])
    {
        $this->ajaxReturn(LError::SUCCESS, 'ok', $data);
    }
}