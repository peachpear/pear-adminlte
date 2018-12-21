<?php
namespace backend\controllers;

use Yii;
//use common\logic\user\UserLogic;

/**
 * 用户管理
 * Class UserController
 * @package backend\controllers
 */
class UserController extends CommonController
{
    /**
     * 用户权限过滤
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction( $action )
    {
        if ( parent::beforeAction($action) ) {
            // 普通用户不能操作该类
            if ( Yii::$app->user->identity->type == 30 ) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * 用户列表页
     * @return string
     */
    public function actionUsers()
    {
        return $this->renderPartial('users');
    }

    /**
     * 用户列表——翻页
     * @param string $type
     * @param string $status
     * @param string $nickname
     * @return string
     */
    public function actionUsersPage( $type = "", $status = "", $nickname = "" )
    {
        // 初始化
        $params = [];

        // 搜索条件赋值
        if ( !empty($type) ) {
            $params['type'] = $type;
        }
        // 管理员只查看普通用户
        if ( Yii::$app->user->identity->type == 20 ) {
            $params['type'] = 30;
        }

        if( !empty($status) ) {
            $params['status'] = $status;
        }

        if ( !empty($nickname) ) {
            $params['nickname'] = $nickname;
        }

        // 执行
        $total = UserLogic::getUsersTotal( $params );

        return $this->renderPartial('users-page', ['count' => $total]);
    }

    /**
     * 用户列表——数据
     * @param string $type
     * @param string $status
     * @param string $nickname
     * @param string $order_name
     * @param string $order_type
     * @param int $page_num
     * @return string
     */
    public function actionUsersLists( $type = "", $status = "", $nickname = "", $order_name = "", $order_type = "", $page_num = 1 )
    {
        // 初始化
        $params = [];

        // 搜索条件赋值
        if ( !empty($type) ) {
            $params['type'] = $type;
        }
        // 管理员只查看普通用户
        if ( Yii::$app->user->identity->type == 20 ) {
            $params['type'] = 30;
        }

        if( !empty($status) ) {
            $params['status'] = $status;
        }

        if ( !empty($nickname) ) {
            $params['nickname'] = $nickname;
        }

        $orders = [
            [
                'name' => $order_name,
                'type' => $order_type == 1 ? 'DESC' : 'ASC',
            ],
        ];

        $pages = [
            'size' => 15,
            'num' => $page_num
        ];

        // 执行
        $data = UserLogic::getUsersList( $params, $orders, $pages );

        return $this->renderPartial('users-lists', ['data' => $data]);
    }

    /**
     * 用户添加/更新——页面
     * @param int $user_id
     * @return string
     */
    public function actionUserAdd( $user_id = 0 )
    {
        $data = [];

        if ( !empty($user_id) ) {
            $params['id'] = $user_id;

            // 管理员只查看普通用户
            if ( Yii::$app->user->identity->type == 20 ) {
                $params['type'] = 30;
            }

            $data = UserLogic::getUserInfo( $params );
        }

        return $this->renderPartial('user-add', ['data' => $data]);
    }

    /**
     * 用户添加/更新——保存
     * @return string
     */
    public function actionUserPost()
    {
        $req = Yii::$app->request;

        if ( !$req->isPost ) {
            return json_encode([
                'code' => 2001,
                'msg' => '非法提交',
                'data' => [],
            ]);
        }

        $params['id'] = !empty($req->post('id')) ? $req->post('id') : 0;

        $params['type'] = $req->post('type');
        if ( empty($params['type']) ) {
            return json_encode([
                'code' => 2010,
                'msg' => '请选择用户类型',
                'data' => [],
            ]);
        }
        // 管理员只查看普通用户
        if ( Yii::$app->user->identity->type == 20 ) {
            $params['type'] = 30;
        }

        $params['nickname'] = $req->post('nickname');
        if ( empty($params['nickname']) ) {
            return json_encode([
                'code' => 2010,
                'msg' => '请输入用户姓名',
                'data' => [],
            ]);
        }

        $params['username'] = $req->post('username');
        if ( empty($params['username']) ) {
            return json_encode([
                'code' => 2010,
                'msg' => '请输入用户账户',
                'data' => [],
            ]);
        }

        $where['username'] = $params['username'];
        $user_info = UserLogic::getUserInfo($where);
        if ( $user_info && $user_info->id != $params['id'] ) {
            return json_encode([
                'code' => 2010,
                'msg' => '该用户账户已存在',
                'data' => [],
            ]);
        }

        $params['phone'] = $req->post('phone');
        if ( empty($params['phone']) ) {
            return json_encode([
                'code' => 2010,
                'msg' => '请输入用户手机号码',
                'data' => [],
            ]);
        }

        $params['email'] = $req->post('email');
        if ( empty($params['email']) ) {
            return json_encode([
                'code' => 2010,
                'msg' => '请输入用户邮箱',
                'data' => [],
            ]);
        }

        $params['status'] = $req->post('status');
        if ( empty($params['status']) ) {
            return json_encode([
                'code' => 2010,
                'msg' => '请选择用户状态',
                'data' => [],
            ]);
        }

        $params['updated_user_id'] = Yii::$app->user->id;

        // 保存处理
        $data = UserLogic::saveUserInfo( $params );

        if ( $data['code'] == 200 ) {
            $res = [
                'code' => 200,
                'msg' => 'ok',
                'data' => [],
            ];
        } else {
            $res = [
                'code' => $data['code'],
                'msg' => $data['msg'],
                'data' => [],
            ];
        }

        return json_encode( $res );
    }

    /**
     * 用户删除——保存
     * @return string
     */
    public function actionUserDelete()
    {
        $req = Yii::$app->request;

        if ( !$req->isPost ) {
            return json_encode([
                'code' => 2001,
                'msg' => '非法提交',
                'data' => [],
            ]);
        }

        $params['id'] = $req->post('id');
        if ( empty($params['id']) ) {
            return json_encode([
                'code' => 2010,
                'msg' => '未选择用户',
                'data' => [],
            ]);
        }

        if (Yii::$app->user->identity->type == 20) {
            $where['id'] = $params['id'];
            $user_info = UserLogic::getUserInfo($where);
            if ( $user_info && $user_info->type != 30 ) {
                return json_encode([
                    'code' => 2010,
                    'msg' => '你无权操作该用户',
                    'data' => [],
                ]);
            }
        }

        $params['status'] = 99;

        $params['updated_user_id'] = Yii::$app->user->id;

        // 保存处理
        $data = UserLogic::saveUserInfo( $params );

        if ( $data['code'] == 200 ) {
            $res = [
                'code' => 200,
                'msg' => 'ok',
                'data' => [],
            ];
        } else {
            $res = [
                'code' => $data['code'],
                'msg' => $data['msg'],
                'data' => [],
            ];
        }

        return json_encode( $res );
    }

    /**
     * 用户密码重置—保存
     * @return string
     */
    public function actionUserPasswordReset()
    {
        $req = Yii::$app->request;

        if ( !$req->isPost ) {
            return json_encode([
                'code' => 2001,
                'msg' => '非法提交',
                'data' => [],
            ]);
        }

        $params['id'] = $req->post('id');
        if ( empty($params['id']) ) {
            return json_encode([
                'code' => 2010,
                'msg' => '未选择用户',
                'data' => [],
            ]);
        }

        if (Yii::$app->user->identity->type == 20) {
            $where['id'] = $params['id'];
            $user_info = UserLogic::getUserInfo($where);
            if ( $user_info && $user_info->type != 30 ) {
                return json_encode([
                    'code' => 2010,
                    'msg' => '你无权操作该用户',
                    'data' => [],
                ]);
            }
        }

        $params['auth_key'] = Yii::$app->security->generateRandomString();
        $params['password_hash'] = Yii::$app->security->generatePasswordHash( 'pnl135qwe' );

        $params['updated_user_id'] = Yii::$app->user->id;

        // 保存处理
        $data = UserLogic::saveUserInfo( $params );

        if ( $data['code'] == 200 ) {
            $res = [
                'code' => 200,
                'msg' => 'ok',
                'data' => [],
            ];
        } else {
            $res = [
                'code' => $data['code'],
                'msg' => $data['msg'],
                'data' => [],
            ];
        }

        return json_encode( $res );
    }
}