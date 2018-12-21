<?php
namespace common\models;

use yii;
use common\lib\LActiveRecord;

/**
 * 用户model
 * Class User
 * @package common\models
 */
class User extends LActiveRecord
{
    public static function getDb()
    {
        return yii::$app->db;
    }

    public static function tableName()
    {
        return 'user';
    }
}
