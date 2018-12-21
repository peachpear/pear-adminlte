<?php
namespace common\dao\write\user;

use Yii;
use common\models\User;

/**
 * 用户修改
 * Class WUserDao
 * @package common\dao\write\user
 */
class WUserDao
{
    /**
     * 保存用户信息
     * @param array $params
     * @return array
     */
    public static function saveUserInfo( $params = [] )
    {
        if ( !empty( $params['id'] ) ) {
            $data = User::findOne([
                'id' => $params['id'],
            ]);

            if ( empty($data) ) {
                return [
                    'code' => 3001,
                    'msg' => '目标数据未找到',
                    'data' => [],
                ];
            }

            $data->updated_time = time();
            $data->updated_user_id = $params['updated_user_id'];
        } else {
            $data = new User();

            $data->created_time = $data->updated_time = time();
            $data->created_user_id = $data->updated_user_id = $params['updated_user_id'];
        }

        if ( isset($params['type']) ) {
            $data->type = $params['type'];
        }

        if ( isset($params['username']) ) {
            $data->username = $params['username'];
        }

        if ( isset($params['auth_key']) ) {
            $data->auth_key = $params['auth_key'];
        }

        if ( isset($params['password_hash']) ) {
            $data->password_hash = $params['password_hash'];
        }

        if ( isset($params['password_reset_token']) ) {
            $data->password_reset_token = $params['password_reset_token'];
        }

        if ( isset($params['nickname']) ) {
            $data->nickname = $params['nickname'];
        }

        if ( isset($params['phone']) ) {
            $data->phone = $params['phone'];
        }

        if ( isset($params['email']) ) {
            $data->email = $params['email'];
        }

        if ( isset($params['status']) ) {
            $data->status = $params['status'];
        }

        if ( $data->save() ) {
            return [
                'code' => 200,
                'msg' => 'ok',
                'data' => [
                    'id' => $data->id,
                ],
            ];
        } else {
            return [
                'code' => !empty( $params['id'] ) ? 3015 : 3010,
                'msg' => '数据保存失败',
                'data' => [],
            ];
        }
    }
}