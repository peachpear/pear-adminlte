<?php
namespace backend\controllers;

use backend\models\LoginForm;
use backend\components\BaseController;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Class SiteController
 * @package backend\controllers
 */
class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 用户登录
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ( $model->login() ) {
                $this->ajaxSuccess();
            } else {
                $this->ajaxReturn( 400, '用户名或密码错误', []);
            }
        } else {
            $model->password = '';

            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionIndex()
    {
        echo Yii::$app->request->getPathInfo();
        echo "</br>";
        echo "ddd";die;
    }

}