<?php
namespace common\dao\read\user;

use Yii;
use common\models\User;

/**
 * 用户读取
 * Class RUserDao
 * @package common\dao\read\user
 */
class RUserDao
{
    /**
     * 获取用户总数
     * @param array $params
     * @return mixed
     */
    public static function getUsersTotal( $params = [] )
    {
        $model = User::find();
        $model = self::filterUsers( $model, $params );

        $total = $model->count();

        return $total;
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
        $model = User::find();
        $model = self::filterUsers( $model, $params );
        $model = self::orderUserModel( $model, $orders );

        $pages_num = $pages['num'] ? $pages['num'] : 1;
        $pages_size = $pages['size'] ? $pages['size'] : 10;
        $model->offset( ($pages_num- 1) * $pages_size )->limit( $pages_size );

        return $model->asArray()->all();
    }

    /**
     * 获取用户数据
     * @param array $params
     * @param array $orders
     * @return mixed
     */
    public static function getUsersData( $params = [], $orders = [] )
    {
        $model = User::find();
        $model = self::filterUsers( $model, $params );
        $model = self::orderUserModel( $model, $orders );

        return $model->asArray()->all();
    }

    /**
     * 用户条件过滤
     * @param $model
     * @param array $params
     * @return mixed
     */
    private static function filterUsers( $model, $params = [] )
    {
        if ( isset( $params['type'] ) ) {
            $model->andWhere( 'type = :type', [':type' => $params['type']] );
        }

        if ( isset( $params['types'] ) ) {
            $model->andWhere( ['in', 'type', $params['types']] );
        }

        if ( isset( $params['nickname'] ) ) {
            $model->andWhere( ['like', 'nickname', $params['nickname']] );
        }

        if ( isset( $params['status'] ) ) {
            $model->andWhere( 'status = :status', [':status' => $params['status']] );
        }

        return $model;
    }

    /**
     * 用户获取排序
     * @param $model
     * @param array $orders
     * @return mixed
     */
    public static function orderUserModel( $model, $orders = [] )
    {
        // 排序
        if ( !empty($orders) ) {
            foreach ( $orders as $key => $value )
            {
                switch ( $value['name'] )
                {
                    case 'id':
                        $model->addOrderBy( 'id ' .$value['type'] );
                        break;
                    case 'type':
                        $model->addOrderBy( 'type ' .$value['type'] );
                        break;
                    case 'username':
                        $model->addOrderBy( 'username ' .$value['type'] );
                        break;
                    case 'nickname':
                        $model->addOrderBy( 'nickname ' .$value['type'] );
                        break;
                    case 'phone':
                        $model->addOrderBy( 'phone ' .$value['type'] );
                        break;
                    case 'email':
                        $model->addOrderBy( 'email ' .$value['type'] );
                        break;
                    case 'static':
                        $model->addOrderBy( 'static ' .$value['type'] );
                        break;
                    case 'created_time':
                        $model->addOrderBy( 'created_time ' .$value['type'] );
                        break;
                    case 'updated_time':
                        $model->addOrderBy( 'updated_time ' .$value['type'] );
                        break;
                    default:
                        $model->addOrderBy( $value['name'] .' ' .$value['type'] );
                }
            }
        }

        return $model;
    }

    /**
     * 获取用户详情
     * @param array $params
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getUserInfo( $params = [] )
    {
        $model = User::find();

        if ( isset( $params['id'] ) ) {
            $model->andWhere( 'id = :id', [':id' => $params['id']] );
        }

        if ( isset( $params['type'] ) ) {
            $model->andWhere( 'type = :type', [':type' => $params['type']] );
        }

        if ( isset( $params['types'] ) ) {
            $model->andWhere( ['in', 'type', $params['types']] );
        }

        if ( isset( $params['username'] ) ) {
            $model->andWhere( 'username = :username', [':username' => $params['username']] );
        }

        if ( isset( $params['nickname'] ) ) {
            $model->andWhere( ['like', 'nickname', $params['nickname']] );
        }

        if ( isset( $params['phone'] ) ) {
            $model->andWhere( ['like', 'phone', $params['phone']] );
        }

        if ( isset( $params['email'] ) ) {
            $model->andWhere( ['like', 'email', $params['email']] );
        }

        if ( isset( $params['status'] ) ) {
            $model->andWhere( 'status = :status', [':status' => $params['status']] );
        }

        return  $model->one();
    }

    /**
     * 获取用户详情，通过id
     * @param $id
     * @return null|static
     */
    public static function getUserInfoById( $id )
    {
        return User::findOne( $id );
    }
}

