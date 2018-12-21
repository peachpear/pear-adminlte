<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * Class DemoController
 * @package console\controllers
 */
class DemoController extends Controller
{
    public function actionIndex()
    {
        Yii::error("asdf");
        1/0;
        echo "aaabbb";die;
    }
}