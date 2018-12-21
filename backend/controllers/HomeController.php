<?php
namespace backend\controllers;

use Yii;

/**
 * 框架页面加载控制器
 * Class HomeController
 * @package backend\controllers
 */
class HomeController extends CommonController
{
    /**
     * 框架页
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 左侧菜单
     * @return string
     */
    public function actionMenu()
    {
        return $this->renderPartial('menu');
    }

    /**
     * 右侧内容区
     * @return string
     */
    public function actionContent()
    {
        return $this->renderPartial('content');
    }

}
