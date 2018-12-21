<?php
namespace common\logic\user;

use yii;
use yii\base\Object;
use common\dao\read\user\RUserDao;
use common\dao\write\user\WUserDao;

/**
 * 用户相关操作逻辑类
 * Class UserLogic
 * @package common\logic\user
 */
class UserLogic extends Object
{
    /**
     * 获取用户总数
     * @param array $params
     * @return mixed
     */
    public static function getUsersTotal( $params = [] )
    {
        return RUserDao::getUsersTotal( $params );
    }

    /**
     * 获取用户列表
     * @param array $params
     * @param array $orders
     * @param array $pages
     * @return mixed
     */
    public static function getUsersList( $params = [], $orders = [], $pages = [] )
    {
        $data = RUserDao::getUsersList( $params, $orders, $pages );

        return self::dealUsersData( $data );
    }

    /**
     * 获取用户数据
     * @param array $params
     * @param array $orders
     * @return array
     */
    public static function getUsersData( $params = [], $orders = [] )
    {
        $data = RUserDao::getUsersData( $params, $orders );

        return self::dealUsersData( $data );
    }

    /**
     * 处理用户数据
     * @param array $data
     * @return array
     */
    public static function dealUsersData( $data = [] )
    {
        foreach ( $data as $key => &$value )
        {
            switch( $value['type'] )
            {
                case 10:
                    $value['type_desc'] = '超级管理员';
                    break;
                case 20:
                    $value['type_desc'] = '管理员';
                    break;
                case 30:
                    $value['type_desc'] = '普通用户';
                    break;
                default:
                    $value['type_desc'] = '未定义';
            }

            switch( $value['status'] )
            {
                case 10:
                    $value['status_desc'] = '正常';
                    break;
                case 99:
                    $value['status_desc'] = '禁用';
                    break;
                default:
                    $value['status_desc'] = '未定义';
            }
        }

        return $data;
    }

    /**
     * 获取用户详情
     * @param $params
     * @return array|null|yii\db\ActiveRecord
     */
    public static function getUserInfo( $params = [] )
    {
        return RUserDao::getUserInfo( $params );
    }

    /**
     * 保存用户信息
     * @param array $params
     * @return array
     */
    public static function saveUserInfo( $params = [] )
    {
        if ( empty( $params['id'] ) ) {
            // 密码初始化
            $params['auth_key'] = Yii::$app->security->generateRandomString();
            $params['password_hash'] = Yii::$app->security->generatePasswordHash( 'pnl135qwe' );
        }

        return WUserDao::saveUserInfo( $params );
    }


}
