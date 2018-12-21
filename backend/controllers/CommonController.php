<?php
namespace backend\controllers;

use backend\components\BaseController;
use Yii;
use yii\filters\AccessControl;

/**
 * Class CommonController
 * @package backend\controllers
 */
abstract class CommonController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * 操作权限过滤
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction( $action )
    {
        if ( parent::beforeAction($action) ) {
            // 如果未登录，则跳转到登录页
//            if ( Yii::$app->user->isGuest ) {
//                return Yii::$app->response->redirect( Yii::$app->urlManager->createUrl('site/login') );
//            }

            return true;
        }

        return false;
    }

    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result);
    }

}