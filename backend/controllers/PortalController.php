<?php
namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\LoginForm;

/**
 * 个人门户面板相关操作
 * Class UserController
 * @package backend\controllers
 */
class PortalController extends CommonController
{
    /**
     * 个人密码修改
     * @return string
     */
    public function actionPasswordReset()
    {
        $req = Yii::$app->request;

        if ( $req->isPost ) {
            $params['password_old'] = $req->post('password_old');
            if ( empty($params['password_old']) ) {
                return json_encode([
                    'code' => 2010,
                    'msg' => '请输入原密码',
                    'data' => [],
                ]);
            }

            $params['password_new'] = $req->post('password_new');
            if ( empty($params['password_new']) ) {
                return json_encode([
                    'code' => 2010,
                    'msg' => '请输入新密码',
                    'data' => [],
                ]);
            }

            $params['password_confirm'] = $req->post('password_confirm');
            if ( empty($params['password_confirm']) ) {
                return json_encode([
                    'code' => 2010,
                    'msg' => '请输入确认密码',
                    'data' => [],
                ]);
            }

            if ( $params['password_new'] != $params['password_confirm'] ) {
                return json_encode([
                    'code' => 2010,
                    'msg' => '新密码与确认密码不一致',
                    'data' => [],
                ]);
            }

            if ( $params['password_new'] == $params['password_old'] ) {
                return json_encode([
                    'code' => 2010,
                    'msg' => '新密码与原密码不能相同',
                    'data' => [],
                ]);
            }

            $model = User::findIdentity( Yii::$app->user->id );

            if ( !$model->validatePassword( $params['password_old'] ) ) {
                return json_encode([
                    'code' => 2010,
                    'msg' => '原密码输入错误',
                    'data' => [],
                ]);
            }

            $model->generateAuthKey();
            $model->setPassword( $params['password_new'] );
            $model->updated_user_id = Yii::$app->user->id;

            if ( $model->save() ) {
                Yii::$app->user->login( $model, (new LoginForm)->rememberMe ? 3600 * 24 * 30 : 0 );
                $res = [
                    'code' => 200,
                    'msg' => 'ok',
                    'data' => [],
                ];
            } else {
                $res = [
                    'code' => 3015,
                    'msg' => '密码修改失败',
                    'data' => [],
                ];
            }

            return json_encode( $res );
        }

        return $this->renderPartial('password-reset');
    }
}